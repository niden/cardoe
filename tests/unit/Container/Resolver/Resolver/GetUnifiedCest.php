<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Resolver;

use Phalcon\Container\Resolver\DefaultValueParameter;
use Phalcon\Container\Resolver\Reflector;
use Phalcon\Container\Resolver\Resolver;
use Phalcon\Test\Fixtures\Container\ChildFixtureClass;
use Phalcon\Test\Fixtures\Container\ChildTrait;
use Phalcon\Test\Fixtures\Container\GrandChildTrait;
use Phalcon\Test\Fixtures\Container\ParentFixtureClass;
use Phalcon\Test\Fixtures\Container\ParentTrait;
use Phalcon\Test\Fixtures\Container\WithParentTraitClass;
use Phalcon\Test\Fixtures\Container\WithTraitClass;
use UnitTester;

class GetUnifiedCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - default
     * parameters
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedDefaultParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - default parameters');

        $resolver  = new Resolver(new Reflector());
        $blueprint = $resolver->getUnified(ParentFixtureClass::class);
        $I->assertEquals(
            [
                'store' => new DefaultValueParameter('store', 'seven'),
            ],
            $blueprint->getParameters()
        );
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - parent
     * parameters
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedParentParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - parent parameter');

        $resolver  = new Resolver(new Reflector());
        $blueprint = $resolver->getUnified(ChildFixtureClass::class);
        $expected  = [
            'store' => new DefaultValueParameter('store', 'seven'),
            'other' => new DefaultValueParameter('other', null),
        ];
        $I->assertEquals($expected, $blueprint->getParameters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() -
     * explicit parameters
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedExplicitParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - explicit parameter');

        $resolver = new Resolver(new Reflector());
        $resolver
            ->parameters()
            ->set(
                ParentFixtureClass::class,
                [
                    'store' => 'tuvok',
                ]
            )
        ;

        $blueprint = $resolver->getUnified(ParentFixtureClass::class);
        $expected  = [
            'store' => 'tuvok',
        ];
        $I->assertEquals($expected, $blueprint->getParameters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() -
     * explicit parent parameters
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedExplicitParentParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - explicit parent parameter');

        $resolver = new Resolver(new Reflector());
        $resolver
            ->parameters()
            ->set(
                ParentFixtureClass::class,
                [
                    'store' => 'tuvok',
                ]
            )
        ;

        $blueprint = $resolver->getUnified(ChildFixtureClass::class);
        $expected  = [
            'store' => 'tuvok',
            'other' => new DefaultValueParameter('other', null),
        ];
        $I->assertEquals($expected, $blueprint->getParameters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - parent
     * setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedParentSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - parent setter');

        $resolver = new Resolver(new Reflector());
        $resolver
            ->setters()
            ->set(
                ParentFixtureClass::class,
                [
                    'setData' => 'voyager',
                ]
            )
        ;

        $blueprint = $resolver->getUnified(ChildFixtureClass::class);
        $expected  = [
            'setData' => 'voyager',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() -
     * override setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedOverrideSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - override setter');

        $resolver = new Resolver(new Reflector());
        $resolver
            ->setters()
            ->set(
                ParentFixtureClass::class,
                [
                    'setData' => 'voyager',
                ]
            )
            ->set(
                ChildFixtureClass::class,
                [
                    'setData' => 'borg',
                ]
            )
        ;

        $blueprint = $resolver->getUnified(ChildFixtureClass::class);
        $expected  = [
            'setData' => 'borg',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - twice
     * for merge
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedTwiceForMerge(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - twice for merge');

        $resolver = new Resolver(new Reflector());
        $first    = $resolver->getUnified(ParentFixtureClass::class);
        $second   = $resolver->getUnified(ParentFixtureClass::class);
        $I->assertEquals($first, $second);
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - trait
     * setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedTraitSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - trait setter');

        $resolver = new Resolver(new Reflector());
        $resolver->setters()->set(ParentTrait::class, ['setParent' => 'voyager']);

        $blueprint = $resolver->getUnified(WithTraitClass::class);
        $expected  = [
            'setParent' => 'voyager',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - child
     * trait setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedChildTraitSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - child trait setter');

        $resolver = new Resolver(new Reflector());
        $resolver->setters()->set(ChildTrait::class, ['setChild' => 'equinox']);

        $blueprint = $resolver->getUnified(WithTraitClass::class);
        $expected  = [
            'setChild' => 'equinox',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() -
     * grandchild trait setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedGrandChildTraitSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - grandchild trait setter');

        $resolver = new Resolver(new Reflector());
        $resolver->setters()->set(GrandChildTrait::class, ['setGrandchild' => 'prometheus']);

        $blueprint = $resolver->getUnified(WithTraitClass::class);
        $expected  = [
            'setGrandchild' => 'prometheus',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() - parent
     * trait setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedParentTraitSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - parent trait setter');

        $resolver = new Resolver(new Reflector());
        $resolver->setters()->set(GrandChildTrait::class, ['setGrandchild' => 'prometheus']);

        $blueprint = $resolver->getUnified(WithParentTraitClass::class);
        $expected  = [
            'setGrandchild' => 'prometheus',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Resolver :: getUnified() -
     * override trait setter
     *
     * @since  2019-12-30
     */
    public function containerResolverResolverGetUnifiedOverrideTraitSetter(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Resolver - getUnified() - override trait setter');

        $resolver = new Resolver(new Reflector());
        $resolver
            ->setters()
            ->set(
                ParentTrait::class,
                [
                    'setParent' => 'voyager',
                ]
            )
            ->set(
                ChildTrait::class,
                [
                    'setChild' => 'delta flyer',
                ]
            )
            ->set(
                WithTraitClass::class,
                [
                    'setParent' => 'equinox',
                ]
            )
            ->set(
                WithTraitClass::class,
                [
                    'setChild' => 'alpha flyer',
                ]
            )
        ;

        $blueprint = $resolver->getUnified(WithTraitClass::class);
        $expected  = [
            'setParent' => 'equinox',
            'setChild'  => 'alpha flyer',
        ];
        $I->assertEquals($expected, $blueprint->getSetters());
    }
}
