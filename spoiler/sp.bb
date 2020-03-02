      $text_showspoiler = 'Показать';
      $text_hidespoiler = 'Скрыть';
      $text_forspoiler = 'Скрытый текст';
      $text_forspoiler = 'Spoiler';      
 
      $spolierID = mt_rand();
      $button = "<input class='button' type='button' value='".$text_showspoiler."' onClick=\"if (this.value=='".$text_showspoiler."') 
      {this.value='".$text_hidespoiler."'; document.getElementById('{$spolierID}').style.display='';} 
      else {this.value='".$text_showspoiler."'; document.getElementById('{$spolierID}').style.display='none';}\">";
      $title = ($parm ? "<b>Скрытый текст</b> для {$parm}: {$button}" : "<b>Spoiler</b>: {$button}");
      return "{$title}<br><div class='indent'><div id='{$spolierID}' style='display: none'>{$code_text}</div></div>";
