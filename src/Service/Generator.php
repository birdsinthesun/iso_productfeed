<?php

namespace Bits\IsoProductfeed\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class Generator
{
  
  
    // builds the form
      public function buildFields($form)
    {
        
        $themesArr = [];
        chdir('../');
    
        $bootswatchThemesArr = scandir(getcwd().'/vendor/thomaspark/bootswatch/dist');
        
        chdir('public');
        foreach($bootswatchThemesArr as $bootswatchTheme){
      
          if($bootswatchTheme != "." && $bootswatchTheme != ".."){
            $themesArr[$bootswatchTheme] = ucwords($bootswatchTheme);
          }
          
        }
        $themesArr = array_flip($themesArr);
       
         return $form
           ->add('themes', ChoiceType::class, ['choices'  =>$themesArr])
           ->add('verzeichnis', TextType::class)
           ->add('generieren', SubmitType::class, ['label' => 'Theme Generieren'])
           ->getForm();
         
       
    }
  
      // builds the stylesheet
      public function buildStylesheet($themeAlias, $zielVerzeichnis)
    {
        
        // scss file generieren
        chdir('../');
         $currentDir = getcwd();
     
        $filesystem = new Filesystem();
          if($filesystem->exists($currentDir.'/files/'.$zielVerzeichnis) === false){
              return false;
          }
        $appScssContent = '/* '.$themeAlias.' Theme https://bootswatch.com/'.$themeAlias.'/ */

@import "../../vendor/thomaspark/bootswatch/dist/'.$themeAlias.'/variables";
@import "../../vendor/twbs/bootstrap/scss/bootstrap";
@import "../../vendor/thomaspark/bootswatch/dist/'.$themeAlias.'/bootswatch";';
        
         //chdir('vendor/birdsinthesun/themply');
        $filesystem->dumpFile('assets/styles/app.scss', $appScssContent);
        
        // Stylesheet generieren
        $serverPhpPath = $this->detectPhpPath();
        $feedbackArr = [];
        $stylesheetName = 'themply_'.$themeAlias.'.css';
       
       
        if($filesystem->exists($currentDir.'/var/sass/app.output.css') === false){
            $feedbackArr['error'] = true ;
          }else{
            //chdir('../../../');
      // $console = shell_exec($serverPhpPath.'php82/bin/php bin/console sass:build');
   //   echo "<pre>$console</pre>";exit;
           $feedbackArr['stylesheetName'] = $stylesheetName ;
            $filesystem->copy($currentDir.'/var/sass/app.output.css', $currentDir.'/files/'.$zielVerzeichnis.'/'.$stylesheetName,true);
       
          
        }
       
        chdir('public');
       
         return $feedbackArr;
         
       
    }
    
     // builds the stylesheet
      private function detectPhpPath()
    {
          $pathArr = explode(':',$_SERVER['PATH']);
         //  var_dump($pathArr);
          foreach($pathArr as $path){
              $result = shell_exec($path.'/php83/bin/php bin/console sass:build');
              $result2 = shell_exec($path.'/php83 bin/console sass:build');
              //echo is_string($result).'  2. '.is_string($result2);
              if(is_string($result) || is_string($result2)){
                // echo $result.'  2. '.$result2;
                   return $path;
              }
          }
      
          
      }
}