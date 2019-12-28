<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Argument\AbstractResolver;

use League\Container\Argument\ArgumentResolverInterface;
use Phalcon\Container;
use Phalcon\Test\Fixtures\Container\ArgumentResolver;
use UnitTester;

class GetSetContainerCest
{
    /**
     * Unit Tests Phalcon\Container\Argument\AbstractResolver ::
     * getContainer()/setContainer()
     *
     * @since  2019-12-28
     */
    public function containerArgumentAbstractResolverGetSetContainer(UnitTester $I)
    {
        $I->wantToTest('Container\Argument\AbstractResolver - getContainer()/setContainer()');

        $container = new Container();
        $resolver  = new ArgumentResolver();

        $return = $resolver->setContainer($container);
        $I->assertInstanceOf(Container\ContainerAwareInterface::class, $return);
        $I->assertEquals($container, $resolver->getContainer());
    }

    /**
     * Unit Tests Phalcon\Container\Argument\AbstractResolver ::
     * getContainer() - exception
     *
     * @since  2019-12-28
     */
    public function containerArgumentAbstractResolverGetException(UnitTester $I)
    {
        $I->wantToTest('Container\Argument\AbstractResolver - getContainer() - exception');

        $I->expectThrowable(
            new Container\Exception\ContainerException(
                'Container has not been set'
            ),
            function () {
                (new ArgumentResolver())->getContainer();
            }
        );
    }
}
