<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RuleEngine\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\RuleEngine\Business\Builder\RuleSpecificationBuilder;
use Spryker\Zed\RuleEngine\Business\Builder\RuleSpecificationBuilderInterface;
use Spryker\Zed\RuleEngine\Business\Comparator\Comparator;
use Spryker\Zed\RuleEngine\Business\Comparator\ComparatorChecker;
use Spryker\Zed\RuleEngine\Business\Comparator\ComparatorCheckerInterface;
use Spryker\Zed\RuleEngine\Business\Comparator\ComparatorInterface;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\CompareOperatorInterface;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\ContainsCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\DoesNotContainCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\EqualCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\GreaterCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\GreaterEqualCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\IsInCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\IsNotInCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\LessCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\LessEqualCompareOperator;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\NotEqualCompareOperator;
use Spryker\Zed\RuleEngine\Business\Executor\CollectorRuleExecutor;
use Spryker\Zed\RuleEngine\Business\Executor\CollectorRuleExecutorInterface;
use Spryker\Zed\RuleEngine\Business\Executor\DecisionRuleExecutor;
use Spryker\Zed\RuleEngine\Business\Executor\DecisionRuleExecutorInterface;
use Spryker\Zed\RuleEngine\Business\Resolver\RuleSpecificationProviderResolver;
use Spryker\Zed\RuleEngine\Business\Resolver\RuleSpecificationProviderResolverInterface;
use Spryker\Zed\RuleEngine\Business\Specification\MetaData\MetaDataProvider;
use Spryker\Zed\RuleEngine\Business\Specification\MetaData\MetaDataProviderInterface;
use Spryker\Zed\RuleEngine\Business\Tokenizer\Tokenizer;
use Spryker\Zed\RuleEngine\Business\Tokenizer\TokenizerInterface;
use Spryker\Zed\RuleEngine\Business\Validator\ClauseValidator;
use Spryker\Zed\RuleEngine\Business\Validator\ClauseValidatorInterface;
use Spryker\Zed\RuleEngine\Business\Validator\QueryStringValidator;
use Spryker\Zed\RuleEngine\Business\Validator\QueryStringValidatorInterface;
use Spryker\Zed\RuleEngine\RuleEngineDependencyProvider;

/**
 * @method \Spryker\Zed\RuleEngine\RuleEngineConfig getConfig()
 */
class RuleEngineBusinessFactory extends AbstractBusinessFactory
{
    public function createCollectorRuleExecutor(): CollectorRuleExecutorInterface
    {
        return new CollectorRuleExecutor(
            $this->createRuleSpecificationBuilder(),
            $this->getConfig(),
        );
    }

    public function createDecisionRuleExecutor(): DecisionRuleExecutorInterface
    {
        return new DecisionRuleExecutor(
            $this->createRuleSpecificationBuilder(),
            $this->getConfig(),
        );
    }

    public function createRuleSpecificationBuilder(): RuleSpecificationBuilderInterface
    {
        return new RuleSpecificationBuilder(
            $this->createTokenizer(),
            $this->createRuleSpecificationProviderResolver(),
            $this->createComparatorChecker(),
            $this->createClauseValidator(),
            $this->createMetaDataProvider(),
        );
    }

    public function createTokenizer(): TokenizerInterface
    {
        return new Tokenizer();
    }

    public function createRuleSpecificationProviderResolver(): RuleSpecificationProviderResolverInterface
    {
        return new RuleSpecificationProviderResolver($this->getRuleSpecificationProviderPlugins());
    }

    public function createClauseValidator(): ClauseValidatorInterface
    {
        return new ClauseValidator(
            $this->createComparatorChecker(),
            $this->createMetaDataProvider(),
        );
    }

    public function createQueryStringValidator(): QueryStringValidatorInterface
    {
        return new QueryStringValidator($this->createRuleSpecificationBuilder());
    }

    public function createMetaDataProvider(): MetaDataProviderInterface
    {
        return new MetaDataProvider();
    }

    public function createComparator(): ComparatorInterface
    {
        return new Comparator($this->getCompareOperators());
    }

    public function createComparatorChecker(): ComparatorCheckerInterface
    {
        return new ComparatorChecker($this->getCompareOperators());
    }

    /**
     * @return list<\Spryker\Zed\RuleEngine\Business\Comparator\Operator\CompareOperatorInterface>
     */
    public function getCompareOperators(): array
    {
        return [
            $this->createContainsCompareOperator(),
            $this->createDoesNotContainCompareOperator(),
            $this->createEqualCompareOperator(),
            $this->createGreaterCompareOperator(),
            $this->createGreaterEqualCompareOperator(),
            $this->createIsInCompareOperator(),
            $this->createIsNotInCompareOperator(),
            $this->createLessCompareOperator(),
            $this->createLessEqualCompareOperator(),
            $this->createNotEqualCompareOperator(),
        ];
    }

    public function createContainsCompareOperator(): CompareOperatorInterface
    {
        return new ContainsCompareOperator();
    }

    public function createDoesNotContainCompareOperator(): CompareOperatorInterface
    {
        return new DoesNotContainCompareOperator();
    }

    public function createEqualCompareOperator(): CompareOperatorInterface
    {
        return new EqualCompareOperator();
    }

    public function createGreaterCompareOperator(): CompareOperatorInterface
    {
        return new GreaterCompareOperator();
    }

    public function createGreaterEqualCompareOperator(): CompareOperatorInterface
    {
        return new GreaterEqualCompareOperator();
    }

    public function createIsInCompareOperator(): CompareOperatorInterface
    {
        return new IsInCompareOperator();
    }

    public function createIsNotInCompareOperator(): CompareOperatorInterface
    {
        return new IsNotInCompareOperator();
    }

    public function createLessCompareOperator(): CompareOperatorInterface
    {
        return new LessCompareOperator();
    }

    public function createLessEqualCompareOperator(): CompareOperatorInterface
    {
        return new LessEqualCompareOperator();
    }

    public function createNotEqualCompareOperator(): CompareOperatorInterface
    {
        return new NotEqualCompareOperator();
    }

    /**
     * @return list<\Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\RuleSpecificationProviderPluginInterface>
     */
    public function getRuleSpecificationProviderPlugins(): array
    {
        return $this->getProvidedDependency(RuleEngineDependencyProvider::PLUGINS_RULE_SPECIFICATION_PROVIDER);
    }
}
