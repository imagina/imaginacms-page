<?php


namespace Modules\Page\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;

class PageContentAi
{
  public $aiService;

  function __construct()
  {
    $this->aiService = new AiService();
  }

  public function getPages($quantity = 2)
  {
    //instance the prompt to generate the posts
    $prompt = "Contenido extenso para una pagina WEB con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(["title", "body", "slug"]);
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    //Return response
    return $response;
  }
}
