<?php

declare(strict_types=1);

/*
 * This file is part of Import From CSV Bundle.
 *
 * (c) Marko Cupic 2021 <m.cupic@gmx.ch>
 * @license MIT
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/import-from-csv-bundle
 */

namespace Markocupic\ImportFromCsvBundle\Dca;

use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\Database;
use Contao\DC_Table;
use Contao\File;
use Contao\FilesModel;
use Contao\Input;
use Markocupic\ImportFromCsvBundle\Import\ImportFromCsvHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment as TwigEnvironment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TlImportFromCsv.
 */
class TlImportFromCsv
{
    /**
     * @var bool
     */
    private $reportTableMode = false;

    /**
     * @var ContaoFramework
     */
    private $framework;

    /**
     * @var Request
     */
    private $requestStack;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var TwigEnvironment
     */
    private $twig;

    /**
     * @var ImportFromCsvHelper
     */
    private $importHelper;

    /**
     * @var string
     */
    private $projectDir;

    /**
     * TlImportFromCsv constructor.
     */
    public function __construct(ContaoFramework $framework, RequestStack $requestStack, SessionInterface $session, TranslatorInterface $translator, TwigEnvironment $twig, ImportFromCsvHelper $importHelper, string $projectDir)
    {
        $this->framework = $framework;
        $this->requestStack = $requestStack;
        $this->session = $session;
        $this->translator = $translator;
        $this->twig = $twig;
        $this->importHelper = $importHelper;
        $this->projectDir = $projectDir;
    }

    /**
     * @Callback(table="tl_import_from_csv", target="fields.explanation.input_field")
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generateExplanationMarkup(): string
    {
        return $this->twig->render(
            '@MarkocupicImportFromCsv/help_text.html.twig',
            [
                'help_text' => $this->translator->trans('tl_import_from_csv.infoText', [], 'contao_default'),
            ]
        );
    }

    /**
     * @Callback(table="tl_import_from_csv", target="fields.listLines.input_field")
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generateFileContentMarkup(): string
    {
        /** @var Database $databaseAdapter */
        $databaseAdapter = $this->framework->getAdapter(Database::class);

        /** @var FilesModel $filesModelAdapter */
        $filesModelAdapter = $this->framework->getAdapter(FilesModel::class);

        /** @var Input $inputAdapter */
        $inputAdapter = $this->framework->getAdapter(Input::class);

        $objDb = $databaseAdapter
            ->getInstance()
            ->prepare('SELECT fileSRC FROM tl_import_from_csv WHERE id=?')
            ->execute($inputAdapter->get('id'))
        ;

        $objFilesModel = $filesModelAdapter->findByUuid($objDb->fileSRC);

        // Only launch the import script if file exists
        if (null === $objFilesModel || !is_file($this->projectDir.'/'.$objFilesModel->path)) {
            return '';
        }

        $objFile = new File($objFilesModel->path, true);

        return $this->twig->render(
            '@MarkocupicImportFromCsv/file_content.html.twig',
            [
                'headline' => $this->translator->trans('tl_import_from_csv.fileContent.0', [], 'contao_default'),
                'rows' => $objFile->getContentAsArray(),
            ]
        );
    }

    /**
     * @Callback(table="tl_import_from_csv", target="fields.report.input_field")
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generateReportMarkup(): string
    {
        /*
         * $bag = $this->session->getBag('markocupic_import_from_csv');
         * $arrHead = [
         * // Title
         * 'lang_title' => $this->translator->trans('tl_import_from_csv.importOverview', [], 'contao_default'),
         * // Labels
         * 'lang_datarecords' => $this->translator->trans('tl_import_from_csv.datarecords', [], 'contao_default'),
         * 'lang_successfull_inserts' => $this->translator->trans('tl_import_from_csv.successfullInserts', [], 'contao_default'),
         * 'lang_failed_inserts' => $this->translator->trans('tl_import_from_csv.failedInserts', [], 'contao_default'),
         * 'lang_show_errors_btn' => $this->translator->trans('tl_import_from_csv.showErrorsButton', [], 'contao_default'),
         * 'lang_show_all_btn' => $this->translator->trans('tl_import_from_csv.showAllButton', [], 'contao_default'),
         * // Values
         * 'count_rows' => $bag[ImportFromCsv::SESSION_BAG_KEY]['status']['rows'],
         * 'count_success' => $bag[ImportFromCsv::SESSION_BAG_KEY]['status']['success'],
         * 'count_errors' => $bag[ImportFromCsv::SESSION_BAG_KEY]['status']['errors'],
         * 'int_offset' => $bag[ImportFromCsv::SESSION_BAG_KEY]['status']['offset'],
         * 'int_limit' => $bag[ImportFromCsv::SESSION_BAG_KEY]['status']['limit'],
         * 'is_testmode' => $bag[ImportFromCsv::SESSION_BAG_KEY]['status']['blnTestMode'] > 0 ? true : false,
         * ];
         *
         * $arrReport = $bag[ImportFromCsv::SESSION_BAG_KEY]['report'];
         * $arrRows = \is_array($arrReport) ? $arrReport : [];
         *
         * unset($bag[ImportFromCsv::SESSION_BAG_KEY]);
         * $this->session->set('contao_backend', $bag);
         *
         * return $this->twig->render(
         * '@MarkocupicImportFromCsv/ImportFromCsv/import_report.html.twig',
         * [
         * 'head' => $arrHead,
         * 'rows' => $arrRows,
         * ]
         * );
         * */
    }

    /**
     * @Callback(table="tl_import_from_csv", target="fields.import_table.options")
     */
    public function optionsCbGetTables(): array
    {
        /** @var Database $databaseAdapter */
        $databaseAdapter = $this->framework->getAdapter(Database::class);

        $arrTables = $databaseAdapter
            ->getInstance()
            ->listTables()
        ;

        return \is_array($arrTables) ? $arrTables : [];
    }

    /**
     * @Callback(table="tl_import_from_csv", target="fields.selected_fields.options")
     * @Callback(table="tl_import_from_csv", target="fields.skipValidationFields.options")
     */
    public function optionsCbSelectedFields(): array
    {
        /** @var Database $databaseAdapter */
        $databaseAdapter = $this->framework->getAdapter(Database::class);

        /** @var Input $inputAdapter */
        $inputAdapter = $this->framework->getAdapter(Input::class);

        /** @var Controller $controllerAdapter */
        $controllerAdapter = $this->framework->getAdapter(Controller::class);

        $objDb = $databaseAdapter
            ->getInstance()
            ->prepare('SELECT * FROM tl_import_from_csv WHERE id = ?')
            ->execute($inputAdapter->get('id'))
        ;

        if ('' === $objDb->import_table) {
            return [];
        }

        $controllerAdapter->loadDataContainer($objDb->import_table);

        $arrFields = $GLOBALS['TL_DCA'][$objDb->import_table]['fields'];

        if (!isset($arrFields) || !\is_array($arrFields)) {
            return [];
        }

        $arrOptions = [];

        foreach ($arrFields as $fieldname => $arrField) {
            if (!isset($fieldname)) {
                continue;
            }

            $sql = $arrField['sql'] ?? '';

            $arrOptions[$fieldname] = sprintf('%s [%s]', $fieldname, $sql);
        }

        return $arrOptions;
    }

    /**
     * @Callback(table="tl_import_from_csv", target="edit.buttons")
     */
    public function buttonsCallback(array $arrButtons, DC_Table $dc): array
    {
        return $arrButtons;
    }
}
