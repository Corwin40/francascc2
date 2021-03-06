<?php

namespace App\Controller\Admin;

use App\Entity\Webapp\Articles;
use App\Entity\Webapp\Section;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OtherCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Articles();
        $article->setAuthor($this->getUser());

        return $article;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters); // TODO: Change the autogenerated stub
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel("Contenu de l'article"),
            TextField::new('title', 'Titre'),
            TextEditorField::new('intro', "Texte d'introduction"),
            BooleanField::new('isShowIntro', "afficher le texte d'introduction"),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->hideOnIndex(),
            CodeEditorField::new('content', "Code"),
            AssociationField::new('category', 'Cat??gories'),
            AssociationField::new('section', 'Section'),
            FormField::addPanel("Options de l'article"),
            BooleanField::new('isTitleShow', "Afficher le titre"),
            BooleanField::new('isShowReadMore', "Afficher : Lire la suite"),
            ImageField::new('imageFile', 'image')
                ->setFormType(VichImageType::class),
            DateField::new('createAt', 'Cr??er le')
                ->hideOnForm(),
        ];
    }

}
