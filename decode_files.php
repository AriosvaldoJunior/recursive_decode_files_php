
$dir = '../fw_ad';

repassarArquivos($dir);




function converteArquivo($dir)
{
        //
        
    $dataStr = \file_get_contents($dir);
    
    $qtd = preg_match_all('/\?/', $dataStr,$m); // procura quantos caracteres ? possui
    $dataStr = utf8_decode($dataStr); 
    
    $qtd2 = preg_match_all('/\?/', $dataStr,$m);// procura quantos caracteres ? possui
    
    if($qtd != $qtd2)// identifica se há carcateres proibidos em UTF-8 (a conversão muda o caracter para "?")
        return;
    
    system('attrib -r '.$dir);
    $ponteiro = fopen($dir, 'w');
    fwrite($ponteiro, $dataStr);
    $return  = fclose($ponteiro);
    
    
    system('attrib +r '.$dir);
        
}
//converteArquivo($dir.'/lib/adianti/core/AdiantiCoreTranslator.php');

function repassarArquivos($diretorio)
{
    $arrDir = scandir($diretorio);
    foreach($arrDir as $dir)
    {
        if($dir == '.' || $dir == '..')
            continue;
        
        $file = $diretorio.'/'.$dir;
        if(is_file($file) && ehConv( $file ))
            converteArquivo ($file);
        else if(!is_file($file))
            repassarArquivos ( $file );
    }
}
function ehConv($dir)
{
    if(  preg_match( '/\.php$/', $dir ))
        return true;
    if(  preg_match( '/\.js$/', $dir ))
        return true;
    if(  preg_match( '/\.html$/', $dir ))
        return true;
    return false;
}
