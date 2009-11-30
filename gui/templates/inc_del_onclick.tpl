{* 
Testlink Open Source Project - http://testlink.sourceforge.net/
$Id: inc_del_onclick.tpl,v 1.9 2009/11/30 21:52:19 erikeloff Exp $
Purpose: include files for:


rev :
     20071202 - franciscom - changes on delete_confirmation.
     
     20071008 - franciscom - added prototype.js method escapeHTML()
*}
{if $smarty.const.USE_EXT_JS_LIBRARY}
  {include file="inc_ext_js.tpl"}
  {lang_get s='Yes' var="yes_b"}
  {lang_get s='No' var="no_b"}
  {assign var="body_onload" 
          value="onload=\"init_yes_no_buttons('$yes_b','$no_b');\""}
  <script type="text/javascript">
   {literal}
   
  /*
    function: delete_confirmation

    args: o_id: object id, id of object on with do_action will be done.
                is not a DOM id, but an specific application id.
          
          o_name: name of object, used to to give user feedback.

          title: pop up title
                      
          msg: can contain a wildcard (%s), that will be replaced
               with o_name.     
    
    returns: 

  */
  function delete_confirmation(o_id,o_name,title,msg,pFunction)
  {
  	var safe_name = o_name.escapeHTML();
    var safe_title = title;
    var my_msg = msg.replace('%s',safe_name);
    if (!pFunction)
  		pFunction = do_action;
    
    Ext.Msg.confirm(safe_title, my_msg,
  			            function(btn, text)
  			            { 
  					         pFunction(btn,text,o_id);
  			            });
  }
  
  /*
    function: 

    args:
    
    returns: 

  */
  function init_yes_no_buttons(yes_btn,no_btn)
  {
    Ext.MessageBox.buttonText.yes=yes_btn;
    Ext.MessageBox.buttonText.no=no_btn;
  }
  /*
    function: 

    args:
    
    returns: 

  */
  function do_action(btn, text, o_id)
  { 
  	var my_action='';
    
    if( btn == 'yes' )
    {
      my_action=del_action+o_id;
  	  window.location=my_action;
  	}
  }					
  /*
    function: 

    args:
    
    returns: 

  */
  function alert_message(title,msg)
  {
    Ext.MessageBox.alert(title.escapeHTML(), msg.escapeHTML());
  }
  /**
   * Displays an alert message. title and message must be escaped.
   */
  function alert_message_html(title,msg)
  {
    Ext.MessageBox.alert(title, msg);
  }
  {/literal}
  </script>
{else}
  {assign var="body_onload" value=''}
  <script type="text/javascript">
  {literal}
  /*
    function: 

    args:
    
    returns: 

  */
  function delete_confirmation(o_id,o_name,msg) 
  {
  	if (confirm(msg + o_name))
  	{
  		window.location = del_action+o_id;
  	}
  }
  /*
    function: 

    args:
    
    returns: 

  */
  function alert_message(title,msg)
  {
    alert(msg);
  }
  {/literal}
 </script>
{/if}
