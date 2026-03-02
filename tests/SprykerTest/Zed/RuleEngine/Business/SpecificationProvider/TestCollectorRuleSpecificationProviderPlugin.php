<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RuleEngine\Business\SpecificationProvider;

use Generated\Shared\Transfer\RuleEngineClauseTransfer;
use Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\CollectorRulePluginInterface;
use Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\RuleSpecificationProviderPluginInterface;
use Spryker\Zed\RuleEngineExtension\Communication\Dependency\Specification\RuleSpecificationInterface;
use SprykerTest\Zed\RuleEngine\Business\SpecificationProvider\CollectorSpecification\TestCollectorAndSpecification;
use SprykerTest\Zed\RuleEngine\Business\SpecificationProvider\CollectorSpecification\TestCollectorContext;
use SprykerTest\Zed\RuleEngine\Business\SpecificationProvider\CollectorSpecification\TestCollectorOrSpecification;

class TestCollectorRuleSpecificationProviderPlugin implements RuleSpecificationProviderPluginInterface
{
    /**
     * @var string
     */
    protected const TEST_DOMAIN_NAME = 'test-domain-name';

    /**
     * @var string
     */
    protected const SPECIFICATION_TYPE = 'collector';

    /**
     * @var \Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\CollectorRulePluginInterface
     */
    protected CollectorRulePluginInterface $rulePlugin;

    public function __construct(CollectorRulePluginInterface $rulePlugin)
    {
        $this->rulePlugin = $rulePlugin;
    }

    public function getDomainName(): string
    {
        return static::TEST_DOMAIN_NAME;
    }

    public function getSpecificationType(): string
    {
        return static::SPECIFICATION_TYPE;
    }

    public function getRuleSpecificationContext(RuleEngineClauseTransfer $ruleEngineClauseTransfer): RuleSpecificationInterface
    {
        return new TestCollectorContext($this->rulePlugin, $ruleEngineClauseTransfer);
    }

    public function createAnd(RuleSpecificationInterface $leftNode, RuleSpecificationInterface $rightNode): RuleSpecificationInterface
    {
        return new TestCollectorAndSpecification($leftNode, $rightNode);
    }

    public function createOr(RuleSpecificationInterface $leftNode, RuleSpecificationInterface $rightNode): RuleSpecificationInterface
    {
        return new TestCollectorOrSpecification($leftNode, $rightNode);
    }

    /**
     * @return list<\Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\CollectorRulePluginInterface>
     */
    public function getRulePlugins(): array
    {
        return [
            $this->rulePlugin,
        ];
    }
}
