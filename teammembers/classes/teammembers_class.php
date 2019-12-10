<?php 

// Generated e107 Plugin Admin Area 

class TeamMembers extends Db_object_teammembers {

  protected static $db_table        = "team_members";
  protected static $plugin_name     = "teammembers";
  protected static $db_pid          = "uid";  
  protected static $db_table_fields = array('userid', 'title', 'sef', 'position', 'phone', 'email', 'bio', 'image', 'date', 'status', 'order', 'links_multi'
    , 'facts_multi',  'awards_multi', 'website',  'summary'   );
	protected static $use_sc          = true;
  
  public $uid; 
  public $userid;
  public $title;     
  public $sef;
	public $position;
	public $phone;
	public $email;
	public $website;
	public $summary;
	public $bio;
	public $image;
	public $date;
	public $status;
	public $order;
	public $links_multi;  
	public $facts_multi;    
  public $awards_multi; 
  
  //{FANFICTION_NEWS: nid}
  //{FANFICTION_NEWS: author}  
  //{FANFICTION_NEWS: title} 
  //{FANFICTION_NEWS: story}
  //{FANFICTION_NEWS: time}
  //{FANFICTION_NEWS: comments}
 
 
}

 