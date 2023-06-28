<?php


namespace Modules\Page\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\IAService;

class PageContentIA
{
  public $iaService;

  function __construct()
  {
    $this->iaService = new IAService();
  }

  public function getPages($quantity = 2)
  {
    //instance the prompt to generate the posts
    $prompt = "Contenido extenso para una pagina WEB con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->iaService->getStandardPrompts(["title", "body", "slug"]);
    //Call IA Service
    $response = $this->iaService->getContent($prompt, $quantity);
    //Return response
    return $response;
  }
}
