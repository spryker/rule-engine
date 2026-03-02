<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RuleEngine;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\RuleEngine\RuleEngineConfig getConfig()
 */
class RuleEngineDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_RULE_SPECIFICATION_PROVIDER = 'PLUGINS_RULE_SPECIFICATION_PROVIDER';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addRuleSpecificationProviderPlugins($container);

        return $container;
    }

    protected function addRuleSpecificationProviderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_RULE_SPECIFICATION_PROVIDER, function () {
            return $this->getRuleSpecificationProviderPlugins();
        });

        return $container;
    }

    /**
     * @return list<\Spryker\Zed\RuleEngineExtension\Communication\Dependency\Plugin\RuleSpecificationProviderPluginInterface>
     */
    protected function getRuleSpecificationProviderPlugins(): array
    {
        return [];
    }
}
