<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RuleEngine\Business\Comparator\Operator;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\RuleEngineClauseBuilder;
use Generated\Shared\Transfer\RuleEngineClauseTransfer;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\LessEqualCompareOperator;
use Spryker\Zed\RuleEngine\Business\Exception\CompareOperatorException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group RuleEngine
 * @group Business
 * @group Comparator
 * @group Operator
 * @group LessEqualCompareOperatorTest
 * Add your own group annotations below this line
 */
class LessEqualCompareOperatorTest extends Unit
{
    public function testAcceptShouldReturnTrueWhenLessEqualExpressionProvided(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::OPERATOR => '<=']))->build();

        // Act
        $isAccepted = $this->createLessEqualCompareOperator()->accept($ruleEngineClauseTransfer);

        // Assert
        $this->assertTrue($isAccepted);
    }

    public function testCompareShouldReturnTrueWhenProvidedValueIsLessThanClauseValue(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '2']))->build();

        // Act
        $isMatching = $this->createLessEqualCompareOperator()->compare($ruleEngineClauseTransfer, '1');

        // Assert
        $this->assertTrue($isMatching);
    }

    public function testCompareWhenShouldReturnTrueProvidedValueEqualsClauseClause(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '1']))->build();

        // Act
        $isMatching = $this->createLessEqualCompareOperator()->compare($ruleEngineClauseTransfer, '1');

        // Assert
        $this->assertTrue($isMatching);
    }

    public function testCompareShouldReturnFalseWhenProvidedValueIsGreaterThanClauseValue(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '1']))->build();

        // Act
        $isMatching = $this->createLessEqualCompareOperator()->compare($ruleEngineClauseTransfer, '2');

        // Assert
        $this->assertFalse($isMatching);
    }

    public function testCompareWhenNonNumericValueUsedShouldThrowException(): void
    {
        // Assert
        $this->expectException(CompareOperatorException::class);

        // Arrange
        $ruleEngineClauseTransfer = new RuleEngineClauseTransfer();

        // Act
        $this->createLessEqualCompareOperator()->compare($ruleEngineClauseTransfer, 'as');
    }

    public function testCompareShouldReturnFalseWhenEmptyValueIsProvided(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '1']))->build();

        // Act
        $isMatching = $this->createLessEqualCompareOperator()->compare($ruleEngineClauseTransfer, '');

        // Assert
        $this->assertFalse($isMatching);
    }

    public function testIsValueValidShouldReturnFalseWhenEmptyValueIsProvided(): void
    {
        // Act
        $isValueValid = $this->createLessEqualCompareOperator()->isValidValue('');

        // Assert
        $this->assertFalse($isValueValid);
    }

    protected function createLessEqualCompareOperator(): LessEqualCompareOperator
    {
        return new LessEqualCompareOperator();
    }
}
