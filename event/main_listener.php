<?php
/**
 *
 * FPB Skeleton Extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Ger, https://github.com/GerB
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace ger\fpbskeleton\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Main event listener
 */
class main_listener implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'ger.feedpostbot.parse_atom_append'		=> 'append_atom',
            'ger.feedpostbot.parse_rdf_append'		=> 'append_rdf',
            'ger.feedpostbot.parse_rss_append'		=> 'append_rss',
            'ger.feedpostbot.submit_post_before'	=> 'change_post',
        );
    }
	
	/**
	 * Pull some extra stuff from ATOM feeds
	 * @param \phpbb\event\data $event The event object
	 */
	public function append_atom($event)
	{
		// We need to duplicate the vars first
		$item = $event['item'];
		$append = $event['append'];
		
		// Get some extra info from the feed
		$foo = isset($item->foo) ? $item->foo : '';
		$bar = isset($item->bar) ? $item->bar : '';
		
		// Attach that to the description like so
		$append['description'] .= $foo;
		
		// Start the item with an image?
		$append['description'] = "<img src='https://www.phpbb.com/assets/images/images/logo_phpbb.png' /><br><br>" . $append['description'];
		
		// And attach $bar as separate var
		$append['bar'] = $bar;
		
		// Now send it back to the event
		$event['append'] = $append;
	}
	
	/**
	 * Pull some extra stuff from RDF feeds
	 * @param \phpbb\event\data $event The event object
	 */
	public function append_rdf($event)
	{
		// We need to duplicate the vars first
		$item = $event['item'];
		$append = $event['append'];
		
		// Get some extra info from the feed
		$foo = isset($item->foo) ? $item->foo : '';
		$bar = isset($item->bar) ? $item->bar : '';
		
		// Attach that to the description like so
		$append['description'] .= $foo;
		
		// Start the item with an image?
		$append['description'] = "<img src='https://www.phpbb.com/assets/images/images/logo_phpbb.png' /><br><br>" . $append['description'];
		
		// And attach $bar as separate var
		$append['bar'] = $bar;
		
		// Now send it back to the event
		$event['append'] = $append;
	}
	
	/**
	 * Pull some extra stuff from RSS feeds
	 * @param \phpbb\event\data $event The event object
	 */
	public function append_rss($event)
	{
		// We need to duplicate the vars first
		$item = $event['item'];
		$append = $event['append'];
		
		// Get some extra info from the feed
		$foo = isset($item->foo) ? $item->foo : '';
		$bar = isset($item->bar) ? $item->bar : '';
		
		// Attach that to the description like so
		$append['description'] .= $foo;
		
		// Start the item with an image?
		$append['description'] = "<img src='https://www.phpbb.com/assets/images/images/logo_phpbb.png' /><br><br>" . $append['description'];
		
		// And attach $bar as separate var
		$append['bar'] = $bar;
		
		// Now send it back to the event
		$event['append'] = $append;
	}

	/**
	 * Override the actual post
	 * @param \phpbb\event\data $event The event object
	 */	
	public function change_post($event)
	{
		// We need to duplicate the vars first
		$data = $event['data'];
		$rss_item = $event['rss_item'];
				
		// We've created an extra var to the rss item in one of the append_XXX functions, add it to the post
		// Deliberately chose a non-set var here since in this shape it will mess up your feeds.
		if (isset($rss_item['foobar'])) 
		{
			// If we do anything to the existing message, we need to go from A to Z with the parsing.
			$post_text = $rss_item['description'];
			$post_text .= $rss_item['bar'];	
		
			// Remember: you have HTML here. You are free to do whatever you want, but you might want to mimic \ger\feedpostbot\classes\driver::html2bbcode
			// If it's only about appending some generic text, you're better off at one of the other events.
			// Now I actually think about it I might make your life easier at some point in the future, but for now you're on your own.


			// This part is ALWAYS required if you alter the message!
			$uid = $bitfield = $options = '';
			$allow_bbcode = $allow_urls = $allow_smilies = true;
			generate_text_for_storage($post_text, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);
			$data['message'] = $post_text; 
			$data['message_md5'] = md5($data['message']); 
		
		}
		
		// Perhaps you've added someting to the rss item that flags it to post a message in an existing topic?
		if (isset($rss_item['baz']))
		{
			$data['topic_id'] = 12345;
		}
		// Now send it back to the event
		$event['data'] = $data;
	}
	
}