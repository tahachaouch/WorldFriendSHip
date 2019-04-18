<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 09/04/2019
 * Time: 13:45
 */

namespace BlogBundle\Tests\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagsTransformer;
use PhPUnit\Framework\TestCase;

class TagsTransformerTest extends TestCase

{

    public function testCreateTagsArrayFromString(){
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->reverseTransform('Hello, Demo');
        $this->assertCount(2, $tags);
        $this->assertSame('Demo', $tags[1]->getLibelle());
    }
    public function testUseAlreadyDefinedTag(){
        $Tag=new Tag();
        $Tag->setLibelle('Chat');
        $transformer = $this->getMockedTransformer([$Tag]);
        $tags = $transformer->reverseTransform('Fun, Entertainment');
        $this->assertCount(2, $tags);
        $this->assertSame('$tag', $tags[0]);
    }

    public function testRemoveEmptyTags(){
        $tags = $this->getMockedTransformer() ->reverseTransform('Hello,, Demo, , ,');
        $this->assertCount(2, $tags);
        $this->assertSame('Demo', $tags[1]->getLibelle());
    }

    public function testRemoveDuplicateTags(){
        $tags = $this->getMockedTransformer() ->reverseTransform('Demo,, Demo, , Demo,');
        $this->assertCount(1, $tags);

    }

    private function getMockedTransformer($result=[]){
        $tagRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tagRepository->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue($result));
        $entityManager = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($tagRepository));
        return new TagsTransformer($entityManager);
    }
}