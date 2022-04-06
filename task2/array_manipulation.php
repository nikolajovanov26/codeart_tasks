<?php

/**
 * Дадена е низа со производи, која треба да се обработи со крајна цел да се добие и испечати низа која ќе ги задоволува следните услови:
 *
 * 1. Секој зеленчук треба да остане
 * 2. Само овошјето кое е поефтино од 10 денари треба да остане
 * 3. Само зачините кои почнуваат на буквата "К" треба да останат независно од дали буквата е голема или мала.
 *
 * На крај доколку сумата од цените на останатите продукти ви изнесува повеќе од 40 сортирајте ги производите по
 * цена во опаѓачки редослед и отстранете продукти почнувајќи од оние со најниска цена се додека вкупната сума не е еднаква или помала од 40
 */

$produkti = [
    "Banana" => [
        "vid" => "ovosje",
        "cena" => 8
    ],
    "jabolko" => [
        "vid" => "ovosje",
        "cena" => 11
    ],
    "Jagoda" => [
        "vid" => "ovosje",
        "cena" => 6
    ],
    "brokula" => [
        "vid" => "zelencuk",
        "cena" => 9
    ],
    "Morkov" => [
        "vid" => "zelencuk",
        "cena" => 14
    ],
    "kari" => [
        "vid" => "zacin",
        "cena" => 4
    ],
    "Kurkuma" => [
        "vid" => "zacin",
        "cena" => 6
    ],
    "bukovec" => [
        "vid" => "zacin",
        "cena" => 8
    ]
];

foreach ($produkti as $key => $value ) {
  if($value['vid'] == "zelencuk"){
    continue;
  } elseif($value['vid'] == "ovosje" && $value['cena'] < 10) {
    continue;
  } elseif($value['vid'] == "zacin" && ((substr($key,0,1) == 'K') || (substr($key,0,1) == 'k'))){
    continue;
  } else {
    unset($produkti[$key]);
  }
}

if(proveriVkupno($produkti)){
  array_multisort(array_column($produkti, 'cena'), SORT_DESC, $produkti);
}

do {
  if(proveriVkupno($produkti)){
    array_pop($produkti);
  }
} while(proveriVkupno($produkti));

?>
<table cellspacing="15">
  <tr>
    <th>Proizvod</th>
    <th>Vid</th>
    <th>Cena</th>
  </tr>

<?php
foreach ($produkti as $key => $value) {
  echo'<tr>
    <td>'.$key.'</td>
    <td>'.$value['vid'].'</td>
    <td>'.$value['cena'].'</td>
  </tr>';
}
?> </table> <?php

function proveriVkupno($produkti){
  $vkupno = 0;
  foreach ($produkti as $key => $value ) {
    $vkupno += $value['cena'];
  }
  if($vkupno >= 40){
    return true;
  }
  return false;
}
?>
