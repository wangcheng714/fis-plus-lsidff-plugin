<?php
function smarty_compiler_html($arrParams,  $smarty){
    $strResourceApiPath = preg_replace('/[\\/\\\\]+/', '/', dirname(__FILE__) . '/FISResource.class.php');
    $strFramework = $arrParams['framework'];
    unset($arrParams['framework']);
    $strAttr = '';
    $strCode  = '<?php ';
    if (isset($strFramework)) {
        $strCode .= 'if(!class_exists(\'FISResource\')){require_once(\'' . $strResourceApiPath . '\');}';
        $strCode .= 'FISResource::setFramework(FISResource::getUri('.$strFramework.', $_smarty_tpl->smarty));';
    }

    //localStorage diff
    $fid = $arrParams['fid'];
    $sampleRate = $arrParams['sampleRate'];
    $cssDiff = $arrParams['cssDiff'];
    unset($arrParams['fid']);
    unset($arrParams['sampleRate']);
    unset($arrParams['cssDiff']);
    if (isset($fid)){
        $strCode .= 'FISResource::setFid(' . $fid . ');';
    }
    if (isset($sampleRate)){
        $strCode .= 'FISResource::setSampleRate(' . $sampleRate . ');';
    }
    if (isset($cssDiff)){
        $strCode .= 'FISResource::setCssDiff(' . $cssDiff . ');';
    }


    $strCode .= ' ?>';
    foreach ($arrParams as $_key => $_value) {
        $strAttr .= ' ' . $_key . '="<?php echo ' . $_value . ';?>"';
    }
    return $strCode . "<html{$strAttr}>";
}

function smarty_compiler_htmlclose($arrParams,  $smarty){
    $strCode = '<?php ';
    $strCode .= '$_smarty_tpl->registerFilter(\'output\', array(\'FISResource\', \'renderResponse\'));';
    $strCode .= '?>';
    $strCode .= '</html>';
    return $strCode;
}
