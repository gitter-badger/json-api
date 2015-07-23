<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 7/22/15
 * Time: 11:57 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Tests\Api\Mapping;

use NilPortugues\Api\Mapping\Mapping;
use NilPortugues\Tests\Api\Dummy\SimpleObject\Post;

class MappingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mapping
     */
    private $mapping;

    /**
     *
     */
    public function setUp()
    {
        $this->mapping = new Mapping(Post::class,  'http://example.com/posts/{postId}', ['postId']);
    }

    /**
     *
     */
    public function tearDown()
    {
        $this->mapping = null;
    }

    /**
     *
     */
    public function testClassAlias()
    {
        $this->mapping->setClassAlias('Message');

        $this->assertEquals('Message', $this->mapping->getClassAlias());
    }

    /**
     *
     */
    public function testAliasedProperties()
    {
        $this->mapping->setPropertyNameAliases(['oldName' => 'newName']);
        $this->assertEquals(['oldName' => 'newName'], $this->mapping->getAliasedProperties());

        $this->mapping->addPropertyAlias('oldName2', 'newName2');
        $this->assertEquals(['oldName' => 'newName', 'oldName2' => 'newName2'], $this->mapping->getAliasedProperties());
    }

    /**
     *
     */
    public function testHiddenProperties()
    {
        $this->mapping->setHiddenProperties(['propertyName']);
        $this->assertEquals(['propertyName'], $this->mapping->getHiddenProperties());

        $this->mapping->hideProperty('secondProperty');
        $this->assertEquals(['propertyName', 'secondProperty'], $this->mapping->getHiddenProperties());
    }

    /**
     *
     */
    public function testIdProperties()
    {
        $this->assertEquals(['postId'], $this->mapping->getIdProperties());

        $this->mapping->addIdProperty('userId');
        $this->assertEquals(['postId', 'userId'], $this->mapping->getIdProperties());
    }

    /**
     *
     */
    public function testRelationships()
    {
        $this->mapping->setRelationships(['friends' => '/api/user/{userId}/friends']);
        $this->mapping->addRelationship('family', '/api/user/{userId}/family');

        $this->assertEquals(
            ['friends' => '/api/user/{userId}/friends', 'family' => '/api/user/{userId}/family'],
            $this->mapping->getRelationships()
        );
    }

    /**
     *
     */
    public function testMetaData()
    {
        $this->mapping->setMetaData(['author' => 'Nil Portugués']);
        $this->mapping->addMetaData('created_in', '0.00001232 seconds');

        $this->assertEquals(
            ['author' => 'Nil Portugués', 'created_in' => '0.00001232 seconds'],
            $this->mapping->getMetaData()
        );
    }

    /**
     *
     */
    public function testFirstUrl()
    {
        $this->mapping->setFirstUrl('/api/post?page=1');
        $this->assertEquals('/api/post?page=1', $this->mapping->getFirstUrl());
    }

    /**
     *
     */
    public function testLastUrl()
    {
        $this->mapping->setLastUrl('/api/post?page=10');
        $this->assertEquals('/api/post?page=10', $this->mapping->getLastUrl());
    }

    /**
     *
     */
    public function testPrevUrl()
    {
        $this->mapping->setPrevUrl('/api/post?page=2');
        $this->assertEquals('/api/post?page=2', $this->mapping->getPrevUrl());
    }

    /**
     *
     */
    public function testNextUrl()
    {
        $this->mapping->setNextUrl('/api/post?page=3');
        $this->assertEquals('/api/post?page=3', $this->mapping->getNextUrl());
    }

    /**
     *
     */
    public function testSelfUrl()
    {
        $this->mapping->setSelfUrl('/api/post/{postId}');
        $this->assertEquals('/api/post/{postId}', $this->mapping->getSelfUrl());
    }

    /**
     *
     */
    public function testRelatedUrl()
    {
        $this->mapping->setRelatedUrl('/api/post/{postId}/related');
        $this->assertEquals('/api/post/{postId}/related', $this->mapping->getRelatedUrl());
    }
}