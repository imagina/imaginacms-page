<?php


namespace Modules\Page\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;

class PageContentAi
{
  public $aiService;
  private $log = "Page: Services|PageContentAi|";
  private $maxAttempts;
  private $pageRepository;
  private $pagesSystemName = ['us'];

  function __construct()
  {
    $this->aiService = new AiService();
    $this->maxAttempts = (int)setting("isite::n8nMaxAttempts", null, 3);
    $this->pageRepository = app("Modules\Page\Repositories\PageRepository");
  }

  public function getPages($quantity = 2,$page)
  {
    \Log::info($this->log."getPages|INIT");

    //instance the prompt to generate the posts
    $prompt = "Contenido extenso para una pagina WEB de: ".$page->title.", con los siguientes atributos:";
    //\Log::info($this->log."getPages|prompt: ".$prompt);
    
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(["title", "body", "slug","tags"]);
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    \Log::info($this->log."getPages|END");
    //Return response
    return $response;
  }

  /**
  * Principal
  */
  public function startProcesses()
  {

    \Log::info($this->log."startProcesses");

    //Show infor in log
    //showDataConnection();

    //Only pages to update
    $pages = $this->getPagesToUpdate();

    if(count($pages)>0){
      //Get new information to each page
      foreach ($pages as $key => $page) {

        $newData = $this->getNewData($page);
        
        if(!is_null($newData)){
          $this->updatePage($page,$newData[0]);

          //Set the process has completed
          $this->aiService->saveAiCompleted("page");
          
        }

      }
    }else{
      \Log::info($this->log."startProcesses|Not pages to update");
    }

  }

  /**
  * Get Pages to Update
  */
  public function getPagesToUpdate()
  {

    $params = [
      "filter" => [
        'systemName' => $this->pagesSystemName//Only this pages
      ],
    ];
      
    $pages = $this->pageRepository->getItemsBy(json_decode(json_encode($params)));

    return $pages;
       
  }

  /**
  * Get the New Data
  */
  public function getNewData($page)
  {
    
    $newData = null;

    $attempts = 0;
    do {
      \Log::info($this->log."getNewData|Attempt:".($attempts+1)."/Max:".$this->maxAttempts);
      $newData = $this->getPages(1,$page);
      if(is_null($newData)){
        $attempts++;
      }else{
        if(isset($newData[0]['es']) && isset($newData[0]['en']) ){
          $inData = $newData[0];

          if(is_array($inData) && isset($inData['es']['body']) && isset($inData['en']['body'])){
            break;
          }else{
            $attempts++;
            \Log::info($this->log."getNewData|NewData Error in format");
          }
          
        }else{
          $attempts++;
          \Log::info($this->log."getNewData|NewData not ES or EN");
        }
      }
    }while($attempts < $this->maxAttempts);

    return $newData;
  }

  /**
  * Update new data to pages
  */
  public function updatePage($page,$data)
  {

    \Log::info($this->log."updatePage|".$page->title);

    $dataToUpdate = [
        'es' => [
          'body' => $data['es']['body']
        ],
        'en' => [
          'body' => $data['en']['body']
        ]
    ];

      // Image Process
    if(isset($data['image'])){
        $file = $this->aiService->saveImage($data['image'][0]);
        $dataToUpdate['medias_single']['mainimage'] = $file->id;
    }

    $this->pageRepository->updateBy($page->id, $dataToUpdate);

  }


}