<?php
/**
 * +-----------------------------------------------------------------------+
 * | Copyright (c) 2010, Till Klampaeckel                                  |
 * | All rights reserved.                                                  |
 * |                                                                       |
 * | Redistribution and use in source and binary forms, with or without    |
 * | modification, are permitted provided that the following conditions    |
 * | are met:                                                              |
 * |                                                                       |
 * | o Redistributions of source code must retain the above copyright      |
 * |   notice, this list of conditions and the following disclaimer.       |
 * | o Redistributions in binary form must reproduce the above copyright   |
 * |   notice, this list of conditions and the following disclaimer in the |
 * |   documentation and/or other materials provided with the distribution.|
 * | o The names of the authors may not be used to endorse or promote      |
 * |   products derived from this software without specific prior written  |
 * |   permission.                                                         |
 * |                                                                       |
 * | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
 * | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
 * | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
 * | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
 * | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
 * | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
 * | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
 * | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
 * | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
 * | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
 * | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
 * |                                                                       |
 * +-----------------------------------------------------------------------+
 * | Author: Till Klampaeckel <till@php.net>                               |
 * +-----------------------------------------------------------------------+
 *
 * PHP version 5
 *
 * @category Testing 
 * @package  Services_UseKetchup
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  GIT: $Id$
 * @link     http://github.com/till/Services_UseKetchup
 */

/**
 * UseKetchupTestCase
 * @ignore
 */
require_once dirname(__FILE__) . '/UseKetchupTestCase.php';

/**
 * UseKetchupNotesTestCase 
 *
 * @category Services
 * @package  Services_UseKetchup
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  Release: @package_version@
 * @link     http://github.com/till/Services_UseKetchup
 */
class UseKetchupNotesTestCase extends UseKetchupTestCase
{
    // Notes

    public function testNotes()
    {
        $meeting        = new stdClass;
        $meeting->title = "This is a test meeting for notes!";
        $this->useKetchup->meetings->add($meeting);

        $meeting = $this->useKetchup->meetings->getLastCreated();

        $item          = new stdClass;
        $item->content = 'This is an important item.';
        $this->useKetchup->items->add($meeting, $item);

        $item = $this->useKetchup->items->getLastCreated();

        $note1          = new stdClass;
        $note1->content = 'note #1';

        $note2          = new stdClass;
        $note2->content = 'note #2';

        $this->useKetchup->notes->add($item, $note1);
        $note1 = $this->useKetchup->notes->getLastCreated();

        $this->useKetchup->notes->add($item, $note2);
        $note2 = $this->useKetchup->notes->getLastCreated();

        $notes = $this->useKetchup->notes->show($item);
        $this->assertTrue(is_array($notes));
        $this->assertEquals(2, count($notes));

        $sort = new stdClass;
        $sort->notes = array($note1->shortcode_url, $note1->shortcode_url);

        $this->assertTrue($this->useKetchup->notes->sort($item, $sort));

        $this->assertTrue($this->useKetchup->notes->delete($note1));

        $note2->content = 'This is now #1';
        $this->assertTrue($this->useKetchup->notes->update($note2));

        $this->useKetchup->meetings->delete($meeting);
    }
}
