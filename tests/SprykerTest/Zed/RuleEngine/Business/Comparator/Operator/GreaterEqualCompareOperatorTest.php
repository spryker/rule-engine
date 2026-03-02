<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RuleEngine\Business\Comparator\Operator;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\RuleEngineClauseBuilder;
use Generated\Shared\Transfer\RuleEngineClauseTransfer;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\GreaterEqualCompareOperator;
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
 * @group GreaterEqualCompareOperatorTest
 * Add your own group annotations below this line
 */
class GreaterEqualCompareOperatorTest extends Unit
{
    public function testAcceptShouldReturnTrueWhenGreaterOrEqualExpressionProvided(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::OPERATOR => '>=']))->build();

        // Act
        $isAccepted = $this->createGreaterEqualCompareOperator()->accept($ruleEngineClauseTransfer);

        // Assert
        $this->assertTrue($isAccepted);
    }

    public function testCompareShouldReturnTrueWhenProvidedValueIsBiggerThanClauseValue(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '1']))->build();

        $isMatching = $this->createGreaterEqualCompareOperator()->compare($ruleEngineClauseTransfer, '2');

        $this->assertTrue($isMatching);
    }

    public function testCompareShouldReturnFalseWhenProvidedValueIsSmallerThanClauseValue(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '2']))->build();

        // Act
        $isMatching = $this->createGreaterEqualCompareOperator()->compare($ruleEngineClauseTransfer, '1');

        // Assert
        $this->assertFalse($isMatching);
    }

    public function testCompareShouldReturnTrueWhenClauseValueIsEqual(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '1']))->build();

        // Act
        $isMatching = $this->createGreaterEqualCompareOperator()->compare($ruleEngineClauseTransfer, '1');

        // Assert
        $this->assertTrue($isMatching);
    }

    public function testCompareShouldThrowExceptionWhenNonNumericValueProvided(): void
    {
        // Assert
        $this->expectException(CompareOperatorException::class);

        // Arrange
        $ruleEngineClauseTransfer = new RuleEngineClauseTransfer();

        // Act
        $this->createGreaterEqualCompareOperator()->compare($ruleEngineClauseTransfer, 'as');
    }

    public function testCompareShouldReturnFalseWhenEmptyValueIsProvided(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::VALUE => '1']))->build();

        // Act
        $isMatching = $this->createGreaterEqualCompareOperator()->compare($ruleEngineClauseTransfer, '');

        // Assert
        $this->assertFalse($isMatching);
    }

    public function testIsValueValidShouldReturnFalseWhenEmptyValueIsProvided(): void
    {
        // Act
        $isValueValid = $this->createGreaterEqualCompareOperator()->isValidValue('');

        // Assert
        $this->assertFalse($isValueValid);
    }

    protected function createGreaterEqualCompareOperator(): GreaterEqualCompareOperator
    {
        return new GreaterEqualCompareOperator();
    }
}
