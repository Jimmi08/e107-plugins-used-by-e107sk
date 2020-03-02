      <?php
      $bb['name']        = 'sp';
      $bb['onclick_var'] = "[sp][/sp]";
      $bb['icon']        = e_PLUGIN_ABS."spoiler/images/spoiler.png";
      $bb['helptext']        = "Spoiler: [sp=subject]Text to be hidden[/sp]";
      $BBCODE_TEMPLATE .= "{BB=sp}";
      $BBCODE_TEMPLATE_SUBMITNEWS .= "{BB=sp}";
      $BBCODE_TEMPLATE_NEWSPOST .= "{BB=sp}";
      $BBCODE_TEMPLATE_ADMIN .= "{BB=sp}";
      $BBCODE_TEMPLATE_CPAGE .= "{BB=sp}";
      $eplug_bb[] = $bb;
      ?>
