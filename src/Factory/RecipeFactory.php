<?php

namespace App\Factory;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use function Symfony\Component\String\u;

/**
 * @extends ModelFactory<Recipe>
 *
 * @method static Recipe|Proxy createOne(array $attributes = [])
 * @method static Recipe[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Recipe[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Recipe|Proxy find(object|array|mixed $criteria)
 * @method static Recipe|Proxy findOrCreate(array $attributes)
 * @method static Recipe|Proxy first(string $sortedField = 'id')
 * @method static Recipe|Proxy last(string $sortedField = 'id')
 * @method static Recipe|Proxy random(array $attributes = [])
 * @method static Recipe|Proxy randomOrCreate(array $attributes = [])
 * @method static Recipe[]|Proxy[] all()
 * @method static Recipe[]|Proxy[] findBy(array $attributes)
 * @method static Recipe[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Recipe[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RecipeRepository|RepositoryProxy repository()
 * @method Recipe|Proxy create(array|callable $attributes = [])
 */
final class RecipeFactory extends ModelFactory
{
    private ?array $availableImages = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => u(self::faker()->words(4, true))->title(),
            'subText' => self::faker()->sentence,
            'imageFilename' => self::faker()->randomElement($this->getImages()),
            'totalTime' => self::faker()->numberBetween(15, 90),
            'ingredients' => [
                '1 cup flour',
                '1/2 tsp baking soda',
                '1/8 cup vegetable oil',
                '1/4 cup natural peanut butter',
                '1/2 cup applesauce go with plain, unsweetened',
                '1/2 cup pumpkin puree make sure you use pure pumpkin, not canned pumpkin pie mix',
                '1 egg',
            ],
            'instructions' => [
                'Preheat oven to 177°C (350 °F)',
                'In a large bowl, combine flour and baking soda.',
                'In a separate bowl mix together vegetable oil, peanut butter, applesauce and pumpkin puree. Once combined, mix in egg and mix until combined.
                Combine wet and dry ingredients and stir until combined.',
                'Pour mixture into an 8" round pan (a square pan can also be used) that has been greased with oil.',
                'Bake for approximately 25-30 minutes or until a toothpick inserted into the center comes out clean and the cake springs back when pressed lightly.',
                'Allow to cool on a wire rack prior to removing from pan.',
                'After cooling, add frosting if desired.',
            ],
            'sourceUrl' => 'https://www.lovefromtheoven.com/spoiled-dog-cake-recipe/',
        ];
    }

    protected function initialize(): self
    {
        $fs = new Filesystem();
        return $this
            ->afterInstantiate(function (Recipe $recipe) use ($fs): void {
                $targetFile = __DIR__ . sprintf('/../DataFixtures/images/%s', $recipe->getImageFilename());
                if (!file_exists($targetFile)) {
                    return;
                }

                $newFilename = self::faker()->slug(2) . '.png';
                $fs->copy(
                    $targetFile,
                    __DIR__ . '/../../public/uploads/recipes/' . $newFilename
                );
                $recipe->setImageFilename($newFilename);
            });
    }

    protected static function getClass(): string
    {
        return Recipe::class;
    }

    private function getImages(): array
    {
        if ($this->availableImages === null) {
            $finder = new Finder();
            $finder->in(__DIR__.'/../DataFixtures/images')
                ->files();

            $this->availableImages = [];
            foreach ($finder as $file) {
                $this->availableImages[] = $file->getFilename();
            }
        }

        return $this->availableImages;
    }
}
