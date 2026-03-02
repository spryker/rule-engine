<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RuleEngine\Business\SpecificationProvider\DecisionRuleSpecification;

use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\RuleEngineExtension\Communication\Dependency\Specification\DecisionRuleSpecificationInterface;
use Spryker\Zed\RuleEngineExtension\Communication\Dependency\Specification\RuleSpecificationInterface;

class TestDecisionRuleOrSpecification implements DecisionRuleSpecificationInterface
{
    /**
     * @var \Spryker\Zed\RuleEngineExtension\Communication\Dependency\Specification\RuleSpecificationInterface
     */
    protected RuleSpecificationInterface $leftNode;

    /**
     * @var \Spryker\Zed\RuleEngineExtension\Communication\Dependency\Specification\RuleSpecificationInterface
     */
    protected RuleSpecificationInterface $rightNode;

    public function __construct(
        RuleSpecificationInterface $leftNode,
        RuleSpecificationInterface $rightNode
    ) {
        $this->leftNode = $leftNode;
        $this->rightNode = $rightNode;
    }

    public function isSatisfiedBy(TransferInterface $satisfyingTransfer): bool
    {
        return $this->leftNode->isSatisfiedBy($satisfyingTransfer) || $this->rightNode->isSatisfiedBy($satisfyingTransfer);
    }
}
