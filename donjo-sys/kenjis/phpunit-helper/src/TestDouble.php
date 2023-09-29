<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

use Closure;
use PHPUnit\Framework\MockObject\Stub\Stub;

use function array_keys;
use function array_merge;
use function call_user_func_array;
use function is_array;
use function is_int;
use function is_object;

trait TestDouble
{
    /**
     * Get Mock Object
     *
     * $email = $this->getMockBuilder('CI_Email')
     *    ->disableOriginalConstructor()
     *    ->onlyMethods(['send'])
     *    ->getMock();
     * $email->method('send')->willReturn(true);
     *
     *  will be
     *
     * $email = $this->getDouble('CI_Email', ['send' => true]);
     *
     * @param class-string<object>              $classname
     * @param array<string, mixed>|array<array> $params            [method_name => return_value]
     * @param bool|array<mixed>                 $constructorParams false: disable constructor, array: constructor params
     *
     * @return mixed PHPUnit mock object
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getDouble(
        string $classname,
        array $params,
        $constructorParams = false
    ) {
        // `disableOriginalConstructor()` is the default, because if we call
        // constructor, it may call `$this->load->...` or other CodeIgniter
        // methods in it. But we can't use them in
        // `$this->request->setCallablePreConstructor()`
        $mockBuilder = $this->getMockBuilder($classname);
        if ($constructorParams === false) {
            $mockBuilder->disableOriginalConstructor();
        } elseif (is_array($constructorParams)) {
            $mockBuilder->setConstructorArgs($constructorParams);
        }

        [$onConsecutiveCalls, $otherCalls, $methods] = $this->processParams($params);

        if ($methods === []) {
            $mock = $mockBuilder->getMock();
        } else {
            $mock = $mockBuilder->onlyMethods($methods)->getMock();
        }

        foreach ($onConsecutiveCalls as $method => $returns) {
            $mock->expects($this->any())->method($method)
                ->will(
                    call_user_func_array(
                        [$this, 'onConsecutiveCalls'],
                        $returns
                    )
                );
        }

        foreach ($otherCalls as $method => $return) {
            if (
                is_object(
                    $return
                ) && ($return instanceof Stub)
            ) {
                $mock->expects($this->any())->method($method)
                    ->will($return);
            } elseif (is_object($return) && $return instanceof Closure) {
                $mock->expects($this->any())->method($method)
                    ->willReturnCallback($return);
            } else {
                $mock->expects($this->any())->method($method)
                    ->willReturn($return);
            }
        }

        return $mock;
    }

    /**
     * @param array<string, mixed>|array<array> $params [method_name => return_value]
     *
     * @return array{0: array<string, array<string>>, 1: array<string, mixed>, 2: string[]}
     */
    private function processParams(array $params): array
    {
        $onConsecutiveCalls = [];
        $otherCalls = [];
        $methods = [];

        foreach ($params as $key => $val) {
            if (is_int($key)) {
                $onConsecutiveCalls = array_merge($onConsecutiveCalls, $val);
                $methods[] = array_keys($val)[0];
            } else {
                $otherCalls[$key] = $val;
                $methods[] = $key;
            }
        }

        return [$onConsecutiveCalls, $otherCalls, $methods];
    }

    /**
     * @param array<mixed>|null $params
     * @param mixed             $expects
     */
    protected function verify(
        object $mock,
        string $method,
        ?array $params,
        $expects,
        string $with
    ): void {
        $invocation = $mock->expects($expects)->method($method);

        if ($params === null) {
            return;
        }

        call_user_func_array([$invocation, $with], $params);
    }

    /**
     * Verifies that method was called exactly $times times
     *
     * $loader->expects($this->exactly(2))
     *    ->method('view')
     *    ->withConsecutive(
     *        ['shop_confirm', $this->anything(), true],
     *        ['shop_tmpl_checkout', $this->anything()]
     *    );
     *
     *  will be
     *
     * $this->verifyInvokedMultipleTimes(
     *    $loader,
     *    'view',
     *    2,
     *    [
     *        ['shop_confirm', $this->anything(), true],
     *        ['shop_tmpl_checkout', $this->anything()]
     *    ]
     * );
     *
     * @param object       $mock   PHPUnit mock object
     * @param array<mixed> $params arguments
     */
    public function verifyInvokedMultipleTimes(
        object $mock,
        string $method,
        int $times,
        ?array $params = null
    ): void {
        $this->verify(
            $mock,
            $method,
            $params,
            $this->exactly($times),
            'withConsecutive'
        );
    }

    /**
     * Verifies a method was invoked at least once
     *
     * @param object       $mock   PHPUnit mock object
     * @param array<mixed> $params arguments
     */
    public function verifyInvoked(
        object $mock,
        string $method,
        ?array $params = null
    ): void {
        $this->verify(
            $mock,
            $method,
            $params,
            $this->atLeastOnce(),
            'with'
        );
    }

    /**
     * Verifies that method was invoked only once
     *
     * @param object       $mock   PHPUnit mock object
     * @param array<mixed> $params arguments
     */
    public function verifyInvokedOnce(
        object $mock,
        string $method,
        ?array $params = null
    ): void {
        $this->verify(
            $mock,
            $method,
            $params,
            $this->once(),
            'with'
        );
    }

    /**
     * Verifies that method was not called
     *
     * @param object       $mock   PHPUnit mock object
     * @param array<mixed> $params arguments
     */
    public function verifyNeverInvoked(
        object $mock,
        string $method,
        ?array $params = null
    ): void {
        $this->verify(
            $mock,
            $method,
            $params,
            $this->never(),
            'with'
        );
    }
}
