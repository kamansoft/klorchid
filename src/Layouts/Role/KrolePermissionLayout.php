<?php

declare (strict_types=1);

namespace Kamansoft\Klorchid\Layouts\Role;

use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Layouts\LayoutTrait;
use Kamansoft\Klorchid\Models\Kuser;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Rows;
use Throwable;

class KrolePermissionLayout extends Rows
{
    use LayoutTrait;

    /**
     * @var Kuser|null
     */
    private ?Kuser $user ;

    /**
     * @var string|null
     */
    private ?string $action;

    /**
     * @var bool
     */
    private bool $is_disabled  = true;
    /**
     * @var string
     */
    private string $field_class = 'form-control';

    /**
     * Views.
     *
     * @return array
     * @throws Throwable
     *
     */
    public function fields(): array
    {
        $this->user = $this->query->get('element');
        $this->action = $this->query->get('form_action');



        $this->is_disabled = !$this->isEditable($this->user);
        $this->field_class = 'form-control ' . $this->getFieldCssClass($this->user);

        return $this->generatedPermissionFields(
            $this->query->getContent('permission')
        );
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @return array
     */
    private function generatedPermissionFields(Collection $permissionsRaw): array
    {
        return $permissionsRaw
            ->map(function (Collection $permissions, $title) {
                return $this->makeCheckBoxGroup($permissions, $title);
            })
            ->flatten()
            ->toArray();
    }

    /**
     * @param Collection $permissions
     * @param string $title
     *
     * @return Collection
     */
    private function makeCheckBoxGroup(Collection $permissions, string $title): Collection
    {

        return $permissions
            ->map(function (array $chunks) {
                return $this->makeCheckBox(collect($chunks));
            })
            ->flatten()
            ->map(function (CheckBox $checkbox, $key) use ($title) {
                return $key === 0
                    ? $checkbox->title($title)
                    : $checkbox;
            })
            ->chunk(4)
            ->map(function (Collection $checkboxes) {
                return Group::make($checkboxes->toArray())
                    ->alignEnd()
                    ->autoWidth();
            });
    }

    /**
     * @param Collection $chunks
     *
     * @return CheckBox
     */
    private function makeCheckBox(Collection $chunks): CheckBox
    {
        $has_permission_edit_permissions  = $this->hasPermission('platform.systems.users.permissions.edit');
        $is_disabled =   $this->is_disabled and !$has_permission_edit_permissions;
        return CheckBox::make('permissions.' . base64_encode($chunks->get('slug')))
            ->placeholder($chunks->get('description'))
            ->value($chunks->get('active'))
            ->disabled($is_disabled)
            ->sendTrueOrFalse()
            ->indeterminate($this->getIndeterminateStatus(
                $chunks->get('slug'),
                $chunks->get('active')
            ));
    }

    /**
     * @param $slug
     * @param $value
     *
     * @return bool
     */
    private function getIndeterminateStatus($slug, $value): bool
    {
        return optional($this->user)->hasAccess($slug) === true && $value === false;
    }
}
