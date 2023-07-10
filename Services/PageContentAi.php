<?php


namespace Modules\Page\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;

class PageContentAi
{
  public $aiService;
  private $log = "Page: Services|PageContentAi|";

  function __construct()
  {
    $this->aiService = new AiService();
  }

  public function getPages($quantity = 2)
  {
    \Log::info($this->log."getPages|INIT");

    //instance the prompt to generate the posts
    $prompt = "Contenido extenso para una pagina WEB con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(["title", "body", "slug"]);
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    \Log::info($this->log."getPages|END");
    //Return response
    return $response;
  }
}
