<?php

$files = array(
  'company.csv',
  'person.csv',
);

foreach($files as $file){
  if(!is_file($file)){
    echo 'Could not find file ' . $file . PHP_EOL;
    continue;
  }
  $type = substr($file, 0, -4); // 'company' or 'person'
  $output = '<?php' . PHP_EOL . '$' . $type . ' = array(' . PHP_EOL;
  $content = file($file);

  // map the headers out and remove from the content
  $headers = current($content);
  $headers = csv_to_array($headers);
  unset($content[0]);

  foreach($content as $row) {
    $row = csv_to_array($row);
    $output .= '  array(' . PHP_EOL;
    foreach($row as $index => $value) {
      $output .= "    '{$headers[$index]}' => '{$value}'," . PHP_EOL;
    }
    $output .= '  ),' . PHP_EOL;
  }

  $output .= ');';

  // write out the file
  $handle = fopen('output/' . $type . '.php','w+');
  fwrite($handle, $output);
  fclose($handle);
}

function csv_to_array($input) {
  $fields = explode(',',$input);
  $result = array();
  foreach($fields as $field) {
    $field = trim($field); // drop whitespace
    if(substr($field, 0, 1) == '"') $field = substr($field, 1); // drop leading double-quote
    if(substr($field, -1) == '"') $field = substr($field, 0, -1); // drop trailing double-quote
    $result[] = $field;
  }
  return $result;
}
