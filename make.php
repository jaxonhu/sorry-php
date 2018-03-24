<?php
header("Content-Type: text/html; charset=utf-8");

$json_string = $_POST;
//$test ='{"{"0":"好啊","1":"就算你是一流工程师","2":"就算你出报告再完美","3":"我叫你改报告你就要改","4":"毕竟我是客户","5":"客户了不起啊","6":"sorry 客户真的了不起","7":"以后叫他天天改报告","8":"天天改 天天改","9":"on"}":""}}';

$json_array = convert_json_to_array($json_string);
$sentences = extract_sentences($json_array);
$template = extract_template($json_array);

$ass_file = make_ass($template, $sentences);
$gif_path = make_gif($template, $sentences, $ass_file);

echo $gif_path;

function convert_json_to_array($json_string){
    $json_encode =  json_encode($json_string,JSON_UNESCAPED_UNICODE);
    // 这里从unicode转为utf8时双引号被转义产生的\要去掉，还有空格转义的_也要替换成相应的空格
    $return_string = str_replace('\\', '', $json_encode);
    $return_string = str_replace('_', ' ', $return_string);
    //不知道为什么XHttpRequest发过来的json串，解析出来之后变成了{"json串":""}，这种形式，所以还要把头尾部分去掉。。。
    $after_cut = substr($return_string,2, -5);
    //php 的json_decode将json串解析为array
    $after_cut = json_decode($after_cut, true);
    return $after_cut;
}

function extract_template($json_array){
    $template = $json_array['template'];
    return $template;
}

function extract_sentences($json_array){
    $sentences = array();
    $i = 0;
    foreach( $json_array as $key => $element){
        if($i == 9){
            break;
        }
        $i += 1;
        array_push($sentences, $element);
    }
    return $sentences;
}

function make_ass($template, $sentences){
    $ass_file = "templates/".$template."/"."template.ass";
    $ass_output = "cache/".$template."_".strtotime("now").".ass";
    $read_file = fopen($ass_file, "r");
    $content = "";
    $i =0;
    $pattern = '/(.*),(<%= sentences\[\d\] %>)/';
    while(!feof($read_file)){
        $line = fgets($read_file);
        if(preg_match($pattern,$line)){
            $sentence = $sentences[$i];
            $i += 1;
            $replacement = '${1},'.$sentence;
            $line = preg_replace($pattern, $replacement, $line);
        }

        $content = $content.$line;
    }

    $write_file = fopen($ass_output, "w");
    iconv("gbk", "utf-8", $content);
    fwrite($write_file, $content);
    fclose($write_file);
//    echo $content;
    return $ass_output;
}

function make_gif($template, $sentences, $ass_file){

    $video_path = "templates/".$template ."/"."template.mp4";
    $ass_path = "templates/".$template."/"."template.ass";
    $gif_path = "cache/".$template."_".strtotime("now").".gif";

    $result = exec('ffmpeg -i '.$video_path.' -r 8 -vf ass='.$ass_file.',scale=300:-1 -y '.$gif_path.'');

//    echo $result;


    return $gif_path;
}

?>
