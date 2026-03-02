<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RuleEngine\Business\Comparator\Operator;

use Generated\Shared\Transfer\RuleEngineClauseTransfer;
use Spryker\Zed\RuleEngine\RuleEngineConfig;

class NotEqualCompareOperator extends AbstractCompareOperator
{
    /**
     * @var string
     */
    protected const EXPRESSION = '!=';

    public function compare(RuleEngineClauseTransfer $ruleEngineClauseTransfer, mixed $withValue): bool
    {
        if (!$this->isValidValue($withValue)) {
            return false;
        }

        return strcasecmp($withValue, $ruleEngineClauseTransfer->getValueOrFail()) !== 0;
    }

    /**
     * @return list<string>
     */
    public function getAcceptedTypes(): array
    {
        return [
            RuleEngineConfig::DATA_TYPE_NUMBER,
            RuleEngineConfig::DATA_TYPE_STRING,
        ];
    }
}
