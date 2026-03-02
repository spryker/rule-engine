<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RuleEngine\Business\Comparator\Operator;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\RuleEngineClauseBuilder;
use Generated\Shared\Transfer\RuleEngineClauseTransfer;
use Spryker\Zed\RuleEngine\Business\Comparator\Operator\IsNotInCompareOperator;
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
 * @group IsNotInCompareOperatorTest
 * Add your own group annotations below this line
 */
class IsNotInCompareOperatorTest extends Unit
{
    /**
     * @uses \Spryker\Zed\RuleEngine\Business\Comparator\Comparator::LIST_DELIMITER
     *
     * @var string
     */
    protected const LIST_DELIMITER = ';';

    public function testAcceptShouldReturnTrueWhenIsNotInExpressionProvided(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([RuleEngineClauseTransfer::OPERATOR => 'is not in']))->build();

        // Act
        $isAccepted = $this->createIsNotInCompareOperator()->accept($ruleEngineClauseTransfer);

        // Assert
        $this->assertTrue($isAccepted);
    }

    public function testCompareShouldReturnTrueWhenValueIsNotInClause(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([
            RuleEngineClauseTransfer::VALUE => implode(static::LIST_DELIMITER, [1, 2, 3]),
        ]))->build();

        // Act
        $isMatching = $this->createIsNotInCompareOperator()->compare($ruleEngineClauseTransfer, '4');

        // Assert
        $this->assertTrue($isMatching);
    }

    public function testCompareShouldReturnFalseWhenValueIsInClause(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([
            RuleEngineClauseTransfer::VALUE => implode(static::LIST_DELIMITER, [1, 2, 3]),
        ]))->build();

        // Act
        $isMatching = $this->createIsNotInCompareOperator()->compare($ruleEngineClauseTransfer, '1');

        // Assert
        $this->assertFalse($isMatching);
    }

    public function testCompareWhenNonScalarValueUsedShouldThrowException(): void
    {
        // Assert
        $this->expectException(CompareOperatorException::class);

        // Arrange
        $ruleEngineClauseTransfer = new RuleEngineClauseTransfer();

        // Act
        $this->createIsNotInCompareOperator()->compare($ruleEngineClauseTransfer, []);
    }

    public function testCompareShouldReturnTrueWhenNoneOfProvidedValuesIsInClause(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([
            RuleEngineClauseTransfer::VALUE => implode(static::LIST_DELIMITER, [1, 2, 3]),
        ]))->build();
        $valueToCompare = implode(static::LIST_DELIMITER, [4, 5]);

        // Act
        $isMatching = $this->createIsNotInCompareOperator()->compare($ruleEngineClauseTransfer, $valueToCompare);

        // Assert
        $this->assertTrue($isMatching);
    }

    public function testCompareShouldReturnFalseWhenAtLeastOneOfProvidedValuesIsInClause(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([
            RuleEngineClauseTransfer::VALUE => implode(static::LIST_DELIMITER, [1, 2, 3]),
        ]))->build();
        $valueToCompare = implode(static::LIST_DELIMITER, [1, 4]);

        // Act
        $isMatching = $this->createIsNotInCompareOperator()->compare($ruleEngineClauseTransfer, $valueToCompare);

        // Assert
        $this->assertFalse($isMatching);
    }

    public function testCompareShouldReturnTrueWhenEmptyValueIsProvided(): void
    {
        // Arrange
        $ruleEngineClauseTransfer = (new RuleEngineClauseBuilder([
            RuleEngineClauseTransfer::VALUE => implode(static::LIST_DELIMITER, [1, 2, 3]),
        ]))->build();

        // Act
        $isMatching = $this->createIsNotInCompareOperator()->compare($ruleEngineClauseTransfer, '');

        // Assert
        $this->assertTrue($isMatching);
    }

    public function testIsValidValueShouldReturnTrueWhenEmptyValueIsProvided(): void
    {
        // Act
        $isMatching = $this->createIsNotInCompareOperator()->isValidValue('');

        // Assert
        $this->assertTrue($isMatching);
    }

    protected function createIsNotInCompareOperator(): IsNotInCompareOperator
    {
        return new IsNotInCompareOperator();
    }
}
