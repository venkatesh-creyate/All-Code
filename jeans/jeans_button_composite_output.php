<?php
/**
 * Created by Shambhu Kumar
 * User: creyate
 * Date: 6/8/14
 * Time: 3:29 PM
 */

/*
    Edited by Venkatesh
*/

define('PRT', DIRECTORY_SEPARATOR);


$inp_dir=getcwd().PRT.$argv[1].PRT;
//echo $inp_dir;
echo "\n";
//$out_dir=;
$butn_dir=getcwd().PRT.$argv[2].PRT;
//echo $butn_dir;
echo "\n";

// the contents of trim directory::::::::

$front_buttons=scandir($butn_dir."buttons//");
//$rivet_70=scandir($butn_dir."70_rivet//");
//$rivet_90=scandir($butn_dir."90_rivet//");
//$rivet_110=scandir($butn_dir."110_rivet");
$fabric_id=array();
foreach($front_buttons as $value){
    if(!is_dir($butn_dir.$value) && $value!=="." && $value!=".." && $value!=="Thumbs.db"){
         $fabric_id[]=PATHINFO($value, PATHINFO_FILENAME);
    }
}
print_r($fabric_id);
//Now going through output directory

$denim_style=scandir($inp_dir);


if(file_exists('Op_Notice_Buttons.txt'))
{
    unlink('Op_Notice_Buttons.txt');
}

if(file_exists('Op_Default_Buttons.txt'))
{
    unlink('Op_Default_Buttons.txt');
}

if(file_exists('Op_Nothing_Buttons.txt'))
{
    unlink('Op_Nothing_Buttons.txt');
}


$wh= getcwd();

delete_dir($wh.PRT.'Op_Notice_Buttons');
delete_dir($wh.PRT.'Op_Default_Buttons');
delete_dir($wh.PRT.'Op_Nothing_Buttons');


function seePlus($coord)
{
    $plus= substr($coord,0,1);

    if($plus !== '+')
    {
        $coord='+'.$coord;
        return $coord;
    }
    else
        return $coord;
}

$count= 0;

foreach($denim_style as $style){
    $style_dir=$inp_dir.$style.PRT;
    //echo $style_dir;
    echo "\n";
    if(is_dir($style_dir) && $style!=="." && $style!==".."){
        $components=scandir($style_dir);

        foreach($components as $component){
            $comp_dir=$style_dir.$component.PRT;
            //echo $comp_dir;
            echo "\n";


            if(is_dir($comp_dir) && $component!=="." && $component!==".."){
                $views=scandir($comp_dir);

                foreach($views as $view){
                    $view_dir=$comp_dir.$view.PRT;
                    //echo $view_dir;
                    echo "\n";
                    if(is_dir($view_dir) && $view!=="." && $view!=".."){
                        $sub_comp=scandir($view_dir);

                        foreach($sub_comp as $subcomponent){
                            $sub_comp_dir=$view_dir.$subcomponent.PRT;
                           // echo $sub_comp_dir;
                            echo "\n";
                            if(is_dir($sub_comp_dir) && $subcomponent!=="." && $subcomponent!==".."){
                                //$category=scandir($sub_comp_dir);
                                $fabric_dir=$sub_comp_dir."fabric".PRT;
                                $button_dir=$sub_comp_dir."button".PRT;
                                $fabric_data=$fabric_dir."options.txt";
                                if(file_exists($fabric_data)){
                                // Edited $file=file_get_contents($fabric_data); to
                                    $file= file($fabric_data, FILE_IGNORE_NEW_LINES);
                                }

                               // echo $file;



                                    foreach($fabric_id as $object){
                                       $tmpfile=$button_dir.$object.".png";
                                       $command="convert -size 1500x1500 xc:none ".$tmpfile;
                                       exec($command);

                                       // Edited $temp=explode("\n",$file);//These are the lines of the file  to
                                       $temp= $file;
                                       //print_r($temp);

                                       
                                        foreach($temp as $value){
                                        $butn_pos=explode("=",$value);//These are the values of one line
                                         // $category=scandir($butn_dir);
                                       // print_r($butn_pos);

                                        echo "\n\n".' Fabric = '.$style."\n";
                                        echo ' JF-JB = '.$component."\n";
                                        echo ' View = '.$view."\n";


                                         switch($butn_pos[0]){


                                            case "70_rivet":
                                                echo "Compositing 70 rivet\n";

                                                if(Comma($butn_pos[1])==0)
                                                {    
                                                    echo "\n".' button coord are '.$butn_pos[1]."\n";
                                                    if(strlen($butn_pos[1]) >= 4)
                                                    {

                                                        $butn= seePlus($butn_pos[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."70_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);
                                                    }
                                                    else
                                                    {
                                                        echo "\n".' No values for 70_rivet '."\n";
                                                        
                                                    }
                                                }
                                                else
                                                    if(Comma($butn_pos[1])== 1)
                                                    {
                                                        echo "\n".' button coord are '.$butn_pos[1]."\n";
                                                        $coord_arr= explode(',', $butn_pos[1]);

                                                        $butn= seePlus($coord_arr[0]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."70_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                        $butn= seePlus($coord_arr[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."70_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                    }


                                                break;

                                            case "90_rivet":

                                            echo 'Compositing 90 rivet '."\n";
                                            if(Comma($butn_pos[1])==0)
                                                {    
                                                    echo "\n".' button coord are '.$butn_pos[1]."\n";

                                                    if(strlen($butn_pos[1]) >= 4)
                                                    {
                                                        $butn= seePlus($butn_pos[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."90_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);
                                                    }
                                                    else
                                                    {
                                                        echo "\n".' No values for 90_rivet '."\n";
                                                        
                                                    }
                                                }
                                                else
                                                    if(Comma($butn_pos[1])== 1)
                                                    {
                                                        echo "\n".' button coord are '.$butn_pos[1]."\n";
                                                        $coord_arr= explode(',', $butn_pos[1]);

                                                        $butn= seePlus($coord_arr[0]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."90_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                        $butn= seePlus($coord_arr[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."90_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                    }


                                                
                                                

                                                break;

                                            case "110_rivet":
                                                echo "Compositing 110 rivet\n";

                                                if(Comma($butn_pos[1])==0)
                                                {   
                                                    echo "\n".' button coord are '.$butn_pos[1]."\n"; 
                                                    if(strlen($butn_pos[1]) >= 4)
                                                    {
                                                        $butn= seePlus($butn_pos[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."110_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);
                                                    }
                                                    else
                                                    {
                                                        echo "\n".' No values for 110_rivet '."\n";
                                                        
                                                    }
                                                }
                                                else
                                                    if(Comma($butn_pos[1])== 1)
                                                    {
                                                        echo "\n".' button coord are '.$butn_pos[1]."\n";
                                                        $coord_arr= explode(',', $butn_pos[1]);

                                                        $butn= seePlus($coord_arr[0]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."110_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                        $butn= seePlus($coord_arr[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."110_rivet//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                    }



                                               

                                                break;

                                            case 'Buttons':
                                            case "buttons":
                                                echo"Compositing buttons rivet\n";

                                                if(Comma($butn_pos[1])==0)
                                                {    
                                                    echo "\n".' button coord are '.$butn_pos[1]."\n";
                                                    if(strlen($butn_pos[1]) >= 4)
                                                    {
                                                        $butn= seePlus($butn_pos[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."buttons//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);
                                                    }
                                                    else
                                                    {
                                                        echo "\n".' No values for buttons '."\n";
                                                        
                                                    }
                                                }
                                                else
                                                    if(Comma($butn_pos[1])== 1)
                                                    {
                                                        echo "\n".' button coord are '.$butn_pos[1]."\n";
                                                        $coord_arr= explode(',', $butn_pos[1]);

                                                        $butn= seePlus($coord_arr[0]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."buttons//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                        $butn= seePlus($coord_arr[1]);

                                                        $command="convert ".$tmpfile." ".$butn_dir."buttons//".$object.".png -geometry ".$butn." -composite ".$tmpfile ;
                                                        exec($command, $arr, $exec);

                                                        getError($exec, $style, $component, $view, $argv[1]);

                                                    }


                                                
                                                break;


                                            case '':

                                                echo "\n".' No value given '."\n";

                                                echo "\n".' Nothing for'.$butn_pos[0].' in options.txt of '."\n";
                                                echo ' Fabric = '.$style."\n";
                                                echo ' JF-JB = '.$component."\n";
                                                echo ' View = '.$view."\n\n";

                                                
                                                file_put_contents('Op_Nothing_Buttons.txt', ' No value for'.$butn_pos[0].' in options.txt of '."\n".' Fabric = '.$style."\n".' JF-JB = '.$component."\n".' View = '.$view."\n\n", FILE_APPEND);

                                                /*
                                                if(!file_exists('Op_Nothing_Buttons'))
                                                {
                                                    mkdir('Op_Nothing_Buttons');
                                                }

                                                copy(getcwd().PRT.$argv[1].PRT.$style.PRT.$component.PRT.$view.PRT.$subcomponent.PRT.'fabric'.PRT.'options.txt', 'Op_Nothing_Buttons'.PRT.'options_nothings_'.$style.'_'.$component.'_'.$view.'.txt');
                                                */

                                                break;


                                            default:
                                                
                                                echo "\n".' default for'.$butn_pos[0].' in options.txt of '."\n";
                                                echo ' Fabric = '.$style."\n";
                                                echo ' JF-JB = '.$component."\n";
                                                echo ' View = '.$view."\n\n";

                                                file_put_contents('Op_Default_Buttons.txt', ' default for'.$butn_pos[0].' in options.txt of '."\n".' Fabric = '.$style."\n".' JF-JB = '.$component."\n".' View = '.$view."\n\n", FILE_APPEND);

                                                if(!file_exists('Op_Default_Buttons'))
                                                {
                                                    mkdir('Op_Default_Buttons');
                                                }

                                                copy(getcwd().PRT.$argv[1].PRT.$style.PRT.$component.PRT.$view.PRT.$subcomponent.PRT.'fabric'.PRT.'options.txt', 'Op_Default_Buttons'.PRT.'options_default_'.$style.'_'.$component.'_'.$view.'.txt');

                                                break;
                                         }
                                      }
                                    }
                                    
                            }
                        }
                    }
                }
            }
        }
    }
}



function getError($exec, $style, $component, $view, $argv)
{

    if($exec== 1)
    {
        if(!file_exists('Op_Notice_Buttons'))
        {
            mkdir('Op_Notice_Buttons');
        }

        $file_return= file_put_contents('Op_Notice_Buttons.txt', ' Error in '."\n".' Fabric = '.$style."\n".' JF-JB = '.$component."\n".' View= '.$view."\n\n", FILE_APPEND);

        copy(getcwd().PRT.$argv.PRT.$style.PRT.$component.PRT.$view.PRT.'dummy'.PRT.'fabric'.PRT.'options.txt', 'Op_Notice_Buttons'.PRT.'options_notice_'.$style.'_'.$component.'_'.$view.'.txt');

        if($file_return=== FALSE)
        {
            echo "\n".' Cannot write to text file '."\n\n";
            exit();
        }
    }

    return 0;
}


function Comma($butn_pos)
{
    $pos= strpos($butn_pos, ',');
    if($pos === FALSE)
    {
        return 0;
    }
    else
    {
        return 1;
    }
}


function delete_dir($handle)
{
    if(file_exists($handle))
    {
        if(PHP_OS == 'Windows')
        {
            $cmn= 'rmdir /q /s '.$handle;
            exec($cmn);
        }
        else
            if(PHP_OS == 'Linux')
            {
                $cmn= 'rmdir --ignore-fail-on-non-empty '.$handle;
                exec($cmn);
            }
    }
}



