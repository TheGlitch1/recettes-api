<?php

namespace App\Namer;

use Exception;
use App\Entity\Image;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
/**
 * @implements DirectoryNamerInterface<\App\Entity\Image>
*/
class ImageDirectoryNamer implements DirectoryNamerInterface 
{

    /**
     * @param Image $object
     * @param \Vich\UploaderBundle\Mapping\PropertyMapping $mapping
     * 
     * @return string
     */
    public function directoryName($object, PropertyMapping $mapping): string
    {
        //TODO : Implementing directoryName() Method so that we strore 
        //image from diffrent entities in different directories while respecting the representation we have in the mcd
        //e.g : Recipe has steps , and both have images linked to them. For images linked to a step of recipe , 
        //Dir.Recipe->Step->MyUploadedImage.png

        $recipe = $object->getRecipe();
        $step = $object->getStep();
        if(!is_null($step)) $recipe = $step->getRecipe();

        if(is_null($recipe)){
            throw new Exception("Recipe and step Must not be empty in images", 1);
        }

        $directoryName = $recipe->getSlug();

        if(!is_null($step)){
            $directoryName = $directoryName . '/' . $step->getId();
        }

        return (string) $directoryName;
    }

}