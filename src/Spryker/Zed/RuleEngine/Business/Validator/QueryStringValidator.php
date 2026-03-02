<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RuleEngine\Business\Validator;

use Generated\Shared\Transfer\ErrorCollectionTransfer;
use Generated\Shared\Transfer\ErrorTransfer;
use Generated\Shared\Transfer\RuleEngineQueryStringValidationRequestTransfer;
use Generated\Shared\Transfer\RuleEngineQueryStringValidationResponseTransfer;
use Generated\Shared\Transfer\RuleEngineSpecificationRequestTransfer;
use Spryker\Zed\RuleEngine\Business\Builder\RuleSpecificationBuilderInterface;
use Spryker\Zed\RuleEngine\Business\Exception\CompareOperatorException;
use Spryker\Zed\RuleEngine\Business\Exception\QueryStringException;

class QueryStringValidator implements QueryStringValidatorInterface
{
    /**
     * @var string
     */
    protected const GLOSSARY_KEY_RULE_ENGINE_VALIDATION_INVALID_QUERY_STRING = 'rule_engine.validation.invalid_query_string';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_RULE_ENGINE_VALIDATION_INVALID_COMPARE_OPERATOR_VALUE = 'rule_engine.validation.invalid_compare_operator_value';

    /**
     * @var \Spryker\Zed\RuleEngine\Business\Builder\RuleSpecificationBuilderInterface
     */
    protected RuleSpecificationBuilderInterface $specificationBuilder;

    public function __construct(RuleSpecificationBuilderInterface $specificationBuilder)
    {
        $this->specificationBuilder = $specificationBuilder;
    }

    public function validate(
        RuleEngineQueryStringValidationRequestTransfer $ruleEngineQueryStringValidationRequestTransfer
    ): RuleEngineQueryStringValidationResponseTransfer {
        $errorCollectionTransfer = new ErrorCollectionTransfer();
        $ruleEngineSpecificationRequestTransfer = (new RuleEngineSpecificationRequestTransfer())
            ->fromArray($ruleEngineQueryStringValidationRequestTransfer->toArray(), true);

        foreach ($ruleEngineQueryStringValidationRequestTransfer->getQueryStrings() as $entityIdentifier => $queryString) {
            $ruleEngineSpecificationRequestTransfer->setQueryString($queryString);
            try {
                $this->specificationBuilder->build($ruleEngineSpecificationRequestTransfer);
            } catch (QueryStringException $e) {
                $errorCollectionTransfer = $this->addError(
                    $errorCollectionTransfer,
                    $entityIdentifier,
                    static::GLOSSARY_KEY_RULE_ENGINE_VALIDATION_INVALID_QUERY_STRING,
                );
            } catch (CompareOperatorException $e) {
                $errorCollectionTransfer = $this->addError(
                    $errorCollectionTransfer,
                    $entityIdentifier,
                    static::GLOSSARY_KEY_RULE_ENGINE_VALIDATION_INVALID_COMPARE_OPERATOR_VALUE,
                );
            }
        }

        return (new RuleEngineQueryStringValidationResponseTransfer())
            ->setErrors($errorCollectionTransfer->getErrors());
    }

    protected function addError(
        ErrorCollectionTransfer $errorCollectionTransfer,
        int|string $entityIdentifier,
        string $message
    ): ErrorCollectionTransfer {
        return $errorCollectionTransfer->addError(
            (new ErrorTransfer())
                ->setMessage($message)
                ->setEntityIdentifier((string)$entityIdentifier),
        );
    }
}
