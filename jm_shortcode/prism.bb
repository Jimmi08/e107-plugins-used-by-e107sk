		$search = array(E_NL,'&#092;','&#036;', '&lt;');
		$replace = array("\r\n","\\",'$', '<');
		$code_text = str_replace($search, $replace, $code_text);
    

$code_text = html_entity_decode($code_text, ENT_QUOTES, 'utf-8');	
				$code_text = trim($code_text);
				$code_text = htmlspecialchars($code_text, ENT_QUOTES, 'utf-8');
        
        
        

return "<pre><code class='language-php'>{$code_text}</code></pre>";                  
 