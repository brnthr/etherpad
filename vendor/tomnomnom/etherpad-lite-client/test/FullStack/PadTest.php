<?php
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', true);

require_once __DIR__.'/../../EtherpadLite/Client.php';

class PadTest extends \PHPUnit_Framework_TestCase {

  protected function newClient(){
    // 4442c5d7688d78cb31f8fa4eb6312bd031e0896f6a4117612d92602b6342050e
    return new \EtherpadLite\Client("dcf118bfc58cc69cdf3ae870071f97149924f5f5a9a4a552fd2921b40830aaae");
  }

  public function testOneGroupOnePad(){
    $client = $this->newClient();
    
    $group = $client->createGroup();
    $this->assertTrue(is_string($group->groupID));

    $pad = $client->createGroupPad($group->groupID, "PadName", "Default Text");
    $this->assertTrue(is_string($pad->padID));
    
    $text = $client->getText($pad->padID);
    $this->assertEquals("Default Text", trim($text->text));

    $set = $client->setText($pad->padID, "The new text");
    $this->assertNull($set);

    $text = $client->getText($pad->padID);
    $this->assertEquals("The new text", trim($text->text));

    $del = $client->deletePad($pad->padID);
    $this->assertNull($del);
  }

}
