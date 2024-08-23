<?php

namespace Feral\Core\Process\NodeCode\Data;

use Feral\Core\Process\Attributes\CatalogNodeDecorator;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\Exception\ProcessException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Feral\Core\Process\NodeCode\Traits\ContextMutationTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Decode a JSON string into an array.
 */
#[ContextConfigurationDescription]
#[StringConfigurationDescription(
    key: self::GET_CONTEXT_PATH,
    name: 'Get Context Path',
    description: 'The context path to read the JSON string from.'
)]
#[CatalogNodeDecorator(
    key:'json_decode',
    name: 'JSON Decode',
    group: 'Data',
    description: 'Convert a string from json into an associative array.',
    configuration: [
        self::CONTEXT_PATH => self::DEFAULT_CONTEXT_PATH,
        self::GET_CONTEXT_PATH => self::DEFAULT_GET_CONTEXT_PATH
    ]
)]
#[OkResultDescription(description: 'The JSON string decoding was successful.')]
class JsonDecodeNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait,
        ContextMutationTrait;

    const KEY = 'json_decode';

    const NAME = 'JSON Decode';

    const DESCRIPTION = 'Convert JSON data to an array in the context';

    public const DEFAULT_GET_CONTEXT_PATH = '_results';
    public const DEFAULT_CONTEXT_PATH = '_data';
    public const CONTEXT_PATH = 'context_path';
    public const GET_CONTEXT_PATH = 'get_context_path';

    public function __construct(
        DataPathReaderInterface $dataPathReader = new DataPathReader(),
        DataPathWriter $dataPathWriter = new DataPathWriter(),
        ConfigurationManager $configurationManager = new ConfigurationManager()
    ) {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::DATA
        )
            ->setConfigurationManager($configurationManager)
            ->setDataPathWriter($dataPathWriter)
            ->setDataPathReader($dataPathReader);
    }


    /**
     * @inheritDoc
     * @throws MissingConfigurationValueException
     * @throws UnknownTypeException
     * @throws ProcessException
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $contextPath = $this->getRequiredConfigurationValue(self::CONTEXT_PATH, self::DEFAULT_CONTEXT_PATH);
        $getContextPath = $this->getRequiredConfigurationValue(self::GET_CONTEXT_PATH, self::DEFAULT_GET_CONTEXT_PATH);

        $jsonString = $this->getStringValueFromContext($getContextPath, $context);
        $arrayData = json_decode($jsonString, true);
        $this->setValueInContext(self::CONTEXT_PATH, $arrayData, $context);

        return $this->result(
            ResultInterface::OK,
            'Converted string data from path "%s" and placed in path "%s"',
            [$getContextPath, $contextPath]
        );
    }
}