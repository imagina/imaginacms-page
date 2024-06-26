<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Services\FinderService;
use Modules\Workshop\Manager\ThemeManager;

class PageTemplatesController extends Controller
{
    /**
     * @var ThemeManager
     */
    private $themeManager;

    /**
     * @var FinderService
     */
    private $finder;

    public function __construct(ThemeManager $themeManager, FinderService $finder)
    {
        $this->themeManager = $themeManager;
        $this->finder = $finder;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return response()->json($this->getTemplates());
    }

    private function getTemplates()
    {
        $path = $this->getCurrentThemeBasePath();

        $templates = [];

        foreach ($this->finder->excluding(config('asgard.page.config.template-ignored-directories', []))->allFiles($path.'/views') as $template) {
            $relativePath = $template->getRelativePath();

            $templateName = $this->getTemplateName($template);
            $file = $this->removeExtensionsFromFilename($template);

            if ($this->hasSubdirectory($relativePath)) {
                $templates[str_replace('/', '.', $relativePath).'.'.$file] = $templateName;
            } else {
                $templates[$file] = $templateName;
            }
        }

        return collect($templates);
    }

    /**
     * Get the base path of the current theme.
     */
    private function getCurrentThemeBasePath(): string
    {
        return $this->themeManager->find(setting('core::template'))->getPath();
    }

    /**
     * Read template name defined in comments.
     */
    private function getTemplateName($template): string
    {
        preg_match('/{{-- Template: (.*) --}}/', $template->getContents(), $templateName);

        if (count($templateName) > 1) {
            return $templateName[1];
        }

        return $this->getDefaultTemplateName($template);
    }

    /**
     * If the template name is not defined in comments, build a default.
     *
     *
     * @return mixed
     */
    private function getDefaultTemplateName($template)
    {
        $relativePath = $template->getRelativePath();
        $fileName = $this->removeExtensionsFromFilename($template);

        return $this->hasSubdirectory($relativePath) ? $relativePath.'/'.$fileName : $fileName;
    }

    /**
     * Remove the extension from the filename.
     *
     *
     * @return mixed
     */
    private function removeExtensionsFromFilename($template)
    {
        return str_replace('.blade.php', '', $template->getFilename());
    }

    /**
     * Check if the relative path is not empty (meaning the template is in a directory).
     */
    private function hasSubdirectory($relativePath): bool
    {
        return ! empty($relativePath);
    }
}
