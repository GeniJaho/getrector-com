<?php

declare(strict_types=1);

namespace App\Controller;

use App\Documentation\DocumentationMenuFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Nette\Utils\FileSystem;
use Webmozart\Assert\Assert;

final class DocumentationController extends Controller
{
    public function __construct(
        private readonly DocumentationMenuFactory $documentationMenuFactory
    ) {
    }

    public function __invoke(string $section = 'introduction'): View
    {
        $documentationFile = __DIR__ . '/../../resources/docs/' . $section . '.md';
        Assert::fileExists($documentationFile);

        $markdownContents = FileSystem::read($documentationFile);

        return \view('docs/section', [
            'section_title' => $this->documentationMenuFactory->createSectionTitle($section),
            'section_markdown_contents' => $markdownContents,
            'documentation_menu_categories' => $this->documentationMenuFactory->create(),
            'codeMirror' => true,
            // seo
            'metaTitle' => 'Rector Docs: PHP Refactoring Guide',
            'metaDescription' => 'Explore Rector’s documentation for PHP code refactoring and upgrades. Learn how to automate and optimize your codebase with ease.',
        ]);
    }
}
