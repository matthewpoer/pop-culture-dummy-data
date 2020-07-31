<?php
require_once('converters/php-arrays.php');
require_once('output/person.php');
require_once('output/company.php');

function localUUID() { return bin2hex(random_bytes(16)); }

$accountNameIdMap = array();
$sql = '';
foreach($company as $i => $c) {
    $id = localUUID();
    $accountNameIdMap[$c['Account Name']] = $id;
    $sql .= "INSERT INTO accounts (id, name, website) VALUES ('{$id}','{$c['Account Name']}','{$c['Website']}');" . PHP_EOL;
}
foreach($person as $i => $p) {
    $id = localUUID();
    $sql .= "INSERT INTO contacts (id, first_name, last_name) VALUES ('{$id}','{$p['First Name']}','{$p['Last Name']}');" . PHP_EOL;

    $e = $p['Email Address'];
    $eID = localUUID();
    $eCaps = strtoupper($e);
    $sql .= "INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('$eID','$e','$eCaps');" . PHP_EOL;
    $sql .= "INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address) VALUES (UUID(), '$eID', '$id', 'Contacts', 1);" . PHP_EOL;

    $accountID = $accountNameIdMap[$p['Account Name']] ?? NULL;
    if(!empty($accountID)) {
        $sql .= "INSERT INTO accounts_contacts (id, account_id, contact_id) VALUES (UUID(),'{$accountID}','{$id}');" . PHP_EOL;
    }
}

foreach($accountNameIdMap as $aName => $aID) {
    $oID = localUUID();
    $sql .= "INSERT INTO opportunities (id, name, amount, amount_usdollar, date_closed, sales_stage, probability) VALUES ('{$oID}', 'Opp for {$aName}', '100', '100', '2020-07-31', 'Prospecting', '10');" . PHP_EOL;
    $sql .= "INSERT INTO accounts_opportunities (id, opportunity_id, account_id) VALUES (UUID(), '{$oID}', '{$aID}');" . PHP_EOL;
    $contactIdQuery = "SELECT ac.contact_id FROM accounts a JOIN accounts_contacts ac ON ac.account_id = a.id WHERE a.id = '${aID}' LIMIT 1";
    $sql .= "INSERT INTO opportunities_contacts (id, opportunity_id, contact_id) VALUES (UUID(), '{$oID}', ({$contactIdQuery}));" . PHP_EOL;
}

file_put_contents('output/sugarcrm.sql', $sql);
