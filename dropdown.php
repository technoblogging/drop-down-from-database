<?php
$host 				= 	"localhost";
$username 			= 	"root";
$password 			= 	"";
$db 				=	"mydb";
$connectionStatus 	=	mysql_connect($host, $username, $password);
if ($connectionStatus) 
{
    $databse 		=	mysql_select_db($db);
    if(!$databse){
    	echo "Database connection fail"; die;
    }
}

echo selectBox(
				$id='', 
				$tableName='cities',
				$fieldText='name', 
				$fieldValue='id', 
				$whereCondition='', 
				$orderBy='', 
				$eventFunction='', 
				$defaultValue='', 
				$helpText='', 
				$disable='', 
				$width='', 
				$controlName='', 
				$printQuery=0, 
				$cssClass='',
				$addtionItems=''
);

function selectBox($id, $tableName,$fieldText, $fieldValue, $whereCondition='', $orderBy='', $eventFunction='', $defaultValue='', $helpText='', $disable='', $width='', $controlName='', $printQuery=0, $cssClass='',$addtionItems='')
{  
	$selectBox='';
	$eventFunctionOnChange=''; 

    if($controlName=='')
    $controlName = $id;

    if($cssClass!='')
    $cssClass = "class=$cssClass";

    if($eventFunction!='')
    $eventFunctionOnChange = " onchange='$eventFunction'";

    $selectBox .=  "<select name='$controlName' id='$id' $disable $eventFunctionOnChange>";

    if($helpText!="")
    $selectBox .= "<option value=''>$helpText</option>";
    else
    $selectBox .= "<option value=''>Select An Option</option>";

    if($tableName!='' && $fieldText!="" && $fieldValue!="" )
    {
        $sqlQuery = "SELECT $fieldText, $fieldValue FROM $tableName "; 
        if($whereCondition!="")
        $sqlQuery  .= " WHERE " . $whereCondition;

        if($orderBy!="")
        $sqlQuery  .= " ORDER BY " . $orderBy;

        if($printQuery==1)
        $this->printText($sqlQuery) ;
        $resultQuery =  mysql_query($sqlQuery);
        if(mysql_num_rows($resultQuery) >0)
        {
            while($row = mysql_fetch_array($resultQuery))
            {
                if($defaultValue==$row[$fieldValue])
                $selectBox .= "<option value='$row[$fieldValue]'  selected='selected'>$row[$fieldText]</option>";
                else
                $selectBox .= "<option value='$row[$fieldValue]'>$row[$fieldText]</option>";
            }
        }
    }
    if($addtionItems!='')
    {
        if($printQuery==1)
        $this->printArray($addtionItems);
        foreach($addtionItems as $key => $value)
        {
            if($defaultValue==$key)
            $selectBox .= "<option value='$key'  selected='selected'  onclick='$eventFunction'  >$value</option>";
            else
            $selectBox .= "<option value='$key' onclick='$eventFunction' >$value</option>";
        }
    }
    $selectBox .= "</select>";
    return $selectBox;
}

?>