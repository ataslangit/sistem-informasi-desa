<?php

declare(strict_types=1);

namespace Kenjis\CI3Compatible\Core\Loader\ClassResolver;

use Kenjis\CI3Compatible\Library\CI_Form_validation;
use Kenjis\CI3Compatible\TestSupport\TestCase;

class LibaryResolverTest extends TestCase
{
    public function test_resolve_ci3_library_name(): void
    {
        $resolver = new LibraryResolver();

        $classname = $resolver->resolve('form_validation');

        $this->assertSame(CI_Form_validation::class, $classname);
    }

    public function test_resolve_user_library_name(): void
    {
        $resolver = new LibraryResolver();

        $classname = $resolver->resolve('twig');

        $this->assertSame('App\Libraries\Twig', $classname);
    }

    public function test_resolve_user_library_name_in_sub_dir(): void
    {
        $resolver = new LibraryResolver();

        $classname = $resolver->resolve('validation/field_validation');

        $this->assertSame('App\Libraries\Validation\Field_validation', $classname);
    }
}
