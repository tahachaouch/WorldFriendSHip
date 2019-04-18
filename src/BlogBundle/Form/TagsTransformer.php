<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 09/04/2019
 * Time: 13:34
 */

namespace BlogBundle\Form;



use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use BlogBundle\Entity\Tag;

class TagsTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     *
     */
    private $manager;
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($value)
    {
        return implode(',', $value);
    }

    public function reverseTransform($string)
    {
        $libelles = array_unique(array_filter(array_map('trim',explode(',', $string))));

        $tags= $this->manager->getRepository('BlogBundle:Tag')->findBy([
            'libelle' => $libelles
        ]);
        $newLibelles= array_diff($libelles, $tags);
        foreach ($newLibelles as $libelle){
            $tag=new Tag();
            $tag->setLibelle($libelle);
            $tags[] =$tag;
        }
        return $tags;

    }
    }
