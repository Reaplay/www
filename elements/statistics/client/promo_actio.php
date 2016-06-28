<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 28.06.2016
     * Time: 19:38
     */


$id_promo = (int)$_POST['promo'];
    if($id_promo) {
        $row = sql_query ("SELECT COUNT(*) AS num , client.status
FROM client
WHERE id_promo_actio = $id_promo AND `delete` = 0 and client.department = '" . $CURUSER['department'] . "'
GROUP BY client.status");
        while ($res = mysql_fetch_array ($row)) {
            $data[$res['status']] = $res['num'];
        }
    }


    $row_promo = sql_query("SELECT id,name FROM promo_actio WHERE status = 0");
    while($res_promo = mysql_fetch_array($row_promo)){
        $data_promo .= '<option value="'.$res_promo['id'].'">'.$res_promo['name'].'</option>';
    }


    $REL_TPL->assignByRef('data',$data);
    $REL_TPL->assignByRef('data_promo',$data_promo);
    $REL_TPL->output("promo_actio","statistics");