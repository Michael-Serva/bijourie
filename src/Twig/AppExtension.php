<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    private $kernelProjectDir;

    // le constructeur indique que nous avons ici besoin d'un paramètre, le kernelProjectDir.
    // Nous allons passer ce paramètre en le déclarant dans notre fichier config/services.yaml. 
    // Il s'agit d'un paramètre par défaut introduit dans Symfony 4.
    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }
    

    public function getFunctions()
    {
        return array(
            // on déclare notre fonction.
            // Le 1er paramètre est le nom de la fonction utilisée dans notre template
            // le 2ème est un tableau dont le 1er élément représente la classe où trouver la fonction associée (en l'occurence $this, c'est à dire cette classe puisque notre fonction est déclarée un peu plus bas). Et le 2ème élément du tableau est le nom de la fonction associée qui sera appelée lorsque nous l'utiliserons dans notre template.
            new TwigFunction('assetExists', array($this, 'assetExistsFunction')),
            new TwigFunction('micky', array($this, 'mickyFunction')),
        );
    }

    // chemin relatif de notre fichier en paramètre
    public function assetExistsFunction(string $fileRelativePath)
    {
        // si le fichier passé en paramètre de la fonction existe, on retourne true, 
        // sinon on retourne false.
        return file_exists($this->kernelProjectDir."/public/".$fileRelativePath) ? true : false;
    }




    public function mickyFunction($prix)
    {
        return $prix . " €";
    }

}