<?

global $module,$sub;

$module = array();
$sub = array();

$i=1;


if(auth()!=3) {
$module[$i] = 'trainings';
$sub[$i][1] = 'add';
$sub[$i][2] = 'add_category';
$i++;

$module[$i] = 'static';
$sub[$i][1] = 'add';
$i++;

$module[$i] = 'articles';
$sub[$i][1] = 'add';
$sub[$i][2] = 'add_category';
$i++;

/*
$module[$i] = 'newsletter';
$sub[$i][1] = 'add';
$sub[$i][2] = 'users';
$i++;
*/

$module[$i] = 'contact';
$i++;

$module[$i] = 'advertising';
$sub[$i][1] = 'add_box';
$i++;

$module[$i] = 'customers';
$sub[$i][1] = 'add';
$i++;

$module[$i] = 'freespace';
$sub[$i][1] = 'add_box';
$i++;

$module[$i] = 'youtube';
$sub[$i][1] = 'add_box';
$i++;
}

$module[$i] = 'contractors';
$i++;

?>