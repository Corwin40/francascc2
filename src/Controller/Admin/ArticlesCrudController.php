<?php

namespace App\Controller\Admin;

use App\Entity\Webapp\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticlesCrudController extends AbstractCrudController
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

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel("Contenu de l'article"),
            TextField::new('title', 'Titre'),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->hideOnIndex(),
            TextEditorField::new('content', "Contenu de l'article"),
            AssociationField::new('category', 'Catégories'),
            AssociationField::new('section', 'Section'),
            AssociationField::new('theme', "Thématique de l'article"),
            AssociationField::new('support', "Support de l'article"),
            ImageField::new('docFile', 'Insertion du fichier')
                ->setFormType(VichFileType::class)
                ->hideOnIndex(),
            FormField::addPanel("Options de l'article"),
            BooleanField::new('isTitleShow', "Afficher le titre"),
            BooleanField::new('isShowReadMore', "Afficher : Lire la suite"),
            ImageField::new('imageFile', 'image')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            DateField::new('createAt', 'Créer le')
                ->hideOnForm(),
        ];
    }

}
