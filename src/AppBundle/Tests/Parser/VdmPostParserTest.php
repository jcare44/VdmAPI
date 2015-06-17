<?php
namespace AppBundle\Tests\Parser;

use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Parser\VdmPostParser;

class VdmPostParserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPost()
    {
        $node = new Crawler('<div class="post article" id="8569674"><p><a href="/travail/8569674" class="fmllink">Aujourd\'hui, et depuis quelques semaines, je demande régulièrement par courriel une semaine de vacances à ma patronne, sans aucune réponse.</a><a href="/travail/8569674" class="fmllink"> En revanche, elle a répondu dans la minute lorsqu\'il fut sujet d\'heures supplémentaires.</a><a href="/travail/8569674" class="fmllink"> VDM</a></p><div class="date"><div class="left_part"><a href="/travail/8569674" id="article_8569674" name="/resume/article/8569674" class="jTip">#8569674</a><br><span class="dyn-comments">45 commentaires</span></div><div class="right_part"><p><span class="dyn-vote-j" id="vote8569674"><a href="javascript:;" onclick="vote(\'8569674\',\'4820\',\'agree\');">je valide, c\'est une VDM</a> (<span class="dyn-vote-j-data">4830</span>)</span> - <span class="dyn-vote-t" id="votebf8569674"><a href="javascript:;" onclick="vote(\'8569674\',\'350\',\'deserve\');" class="bf">tu l\'as bien mérité</a> (<span class="dyn-vote-t-data">351</span>)</span></p><p>Le 17/06/2015 à 05:48 - <a class="liencat" href="/travail">travail</a> - par E-miel </p></div></div><div class="more" id="more8569674"><div style="display: block;" fb-iframe-plugin-query="app_id=360818827295638&amp;container_width=0&amp;font=lucida%20grande&amp;height=21&amp;href=http%3A%2F%2Fwww.viedemerde.fr%2Ftravail%2F8569674&amp;layout=button_count&amp;locale=fr_FR&amp;sdk=joey&amp;send=false&amp;show_faces=false&amp;width=100" fb-xfbml-state="rendered" class="fb-like fb_iframe_widget" data-href="http://www.viedemerde.fr/travail/8569674" data-send="false" data-width="100" data-height="21" data-layout="button_count" data-show-faces="false" data-font="lucida grande"><span style="vertical-align: bottom; width: 0px; height: 0px;"><iframe class="" src="http://www.facebook.com/plugins/like.php?app_id=360818827295638&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2F1ldYU13brY_.js%3Fversion%3D41%23cb%3Df2caf27cb411dbc%26domain%3Dwww.viedemerde.fr%26origin%3Dhttp%253A%252F%252Fwww.viedemerde.fr%252Ff2334d5c938a9ac%26relation%3Dparent.parent&amp;container_width=0&amp;font=lucida%20grande&amp;height=21&amp;href=http%3A%2F%2Fwww.viedemerde.fr%2Ftravail%2F8569674&amp;layout=button_count&amp;locale=fr_FR&amp;sdk=joey&amp;send=false&amp;show_faces=false&amp;width=100" style="border: medium none; visibility: visible; width: 0px; height: 0px;" title="fb:like Facebook Social Plugin" scrolling="no" allowfullscreen="true" allowtransparency="true" name="f28b97416ae1f6" frameborder="0" height="21px" width="100px"></iframe></span></div><a href="javascript:;" onclick="return twitter_click(\'http://www.viedemerde.fr/travail/8569674#new\',\'8569674\');" class="tooltips t_twitter"></a></div></div>');
        $post = (new VdmPostParser($node))->getPost();

        $this->assertEquals('17/06/2015', $post->getPublishedAt()->format('d/m/Y'));
        $this->assertEquals(utf8_encode('E-miel'), $post->getAuthor());
        $this->assertEquals(utf8_encode('Aujourd\'hui, et depuis quelques semaines, je demande régulièrement par courriel une semaine de vacances à ma patronne, sans aucune réponse. En revanche, elle a répondu dans la minute lorsqu\'il fut sujet d\'heures supplémentaires. VDM'), $post->getContent());
    }
}
