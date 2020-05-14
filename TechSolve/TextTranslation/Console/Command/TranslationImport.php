<?php
/**
 * Short description for class
 *
 * PHP version 7.2
 * 
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to rdebnath@TechSolve.com so we can mail you a copy immediately.
 *
 * @category  PHP
 * @package   techSolve_texttranslation
 * @author    Rakesh Debnath <rdebnath@TechSolve.com>
 * @author    Rakesh Debnath <rdebnath@TechSolve.com>
 * @copyright 2019-2020 TechSolve Digital (7908024022)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
namespace TechSolve\TextTranslation\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Short description for class
 *
 * PHP version 7.2
 * 
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to rdebnath@TechSolve.com so we can mail you a copy immediately.
 *
 * @category  PHP
 * @package   techSolve_texttranslation
 * @author    Rakesh Debnath <rdebnath@TechSolve.com>
 * @author    Rakesh Debnath <rdebnath@TechSolve.com>
 * @copyright 2019-2020 TechSolve Digital (7908024022)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class TranslationImport extends Command
{

    const CSV_DIR_FILE = '/design/frontend/TechSolve/abb/i18n/en_US.csv';

    const STORE_ID = 2;

    
    const LOCALE = 'en_US';

    /**
     * State Object
     * 
     * @var \Magento\Framework\App\State
     */
    private $_state;
    /**
     * Directory List
     * 
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $_directoryList;
    /**
     * Translation Object
     * 
     * @var \TechSolve\TextTranslation\Model\TranslationFactory
     */
    private $_translationFactory;
    /**
     * File Object
     * 
     * @var \Magento\Framework\File\Csv
     */
    private $_csv;

    /**
     * Method constructor
     * 
     * @param object \Magento\Framework\App\State                       $_state              StateObject
     * @param object \Magento\Framework\App\Filesystem\DirectoryList    $_directoryList      DirectoryObject
     * @param object \TechSolve\TextTranslation\Model\TranslationFactory $_translationFactory TranslationObject
     * @param object \Magento\Framework\File\Csv                        $_csv                FileObject
     */
    public function __construct(
        \Magento\Framework\App\State $_state,
        \Magento\Framework\App\Filesystem\DirectoryList $_directoryList,
        \TechSolve\TextTranslation\Model\TranslationFactory $_translationFactory,
        \Magento\Framework\File\Csv $_csv
        ) {
        
        $this->_state = $_state;
        $this->_directoryList = $_directoryList;
        $this->_translationFactory = $_translationFactory;
        $this->_csv = $_csv;
        parent::__construct();
    }

    /**
     * Method execute
     * 
     * @param object \Symfony\Component\Console\Input\InputInterface   $input  Input
     * @param object \Symfony\Component\Console\Output\OutputInterface $output Output
     *
     * @return void
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
        ) {
        $this->_state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        $app_directory = $this->_directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::APP);
        $full_path_csv = $app_directory.self::CSV_DIR_FILE;
        
        try{
            $csvData = $this->_csv->getData($full_path_csv);
            $translationObject = $this->_translationFactory->create();
            $data = [];
            foreach ($csvData as $key => $_csvData) {
                $data['string'] = $_csvData[0];
                $data['store_id'] = self::STORE_ID;
                $data['translate'] = $_csvData[1];
                $data['locale'] = self::LOCALE;
                $data['page_section'] = isset($_csvData[2])?$_csvData[2]:'';
                $translationObject->setData($data)->save();
            }

            $output->writeln('Imported Successfully');

        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("techSolve_texttranslation:importtranslation");
        $this->setDescription("import translation from india store");
        parent::configure();
    }
}


