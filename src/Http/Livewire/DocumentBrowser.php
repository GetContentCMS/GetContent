<?php

namespace GetContent\CMS\Http\Livewire;

use GetContent\CMS\Models\Document;
use GetContent\CMS\Models\Group;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentBrowser extends Component
{
    use WithPagination;

    public ?Group $group = null;

    public function render(): \Illuminate\Contracts\View\View
    {
        $documentsQuery = DB::table((new Document)->getTable())
            ->select('uuid', 'name', 'created_at', 'updated_at', DB::raw("'document' as type"))
            ->where('group_id', $this->group->id ?? null)
            ->where('deleted_at', null);

        $groupsQuery = DB::table((new Group)->getTable())
            ->select('uuid', 'name', 'created_at', 'updated_at', DB::raw("'group' as type"))
            ->where('parent_id', $this->group->id ?? null)
            ->where('deleted_at', null);


        $orderBy = ($this->group && $this->group->meta->orderBy) ? $this->group->meta->orderBy : 'name';
        $sort = ($this->group && $this->group->meta->sort) ? $this->group->meta->sort : 'asc';

        $groupsQuery->union($documentsQuery)
            ->orderBy($orderBy, $sort);

        $items = $groupsQuery->paginate(25);
        $items->transform(function ($item) {
            $item->updated_at = Carbon::parse($item->updated_at);
            return $item;
        });

        return view('gc::livewire.document-browser')
            ->with('items', $items)
            ->layout('gc::layouts.app');
    }

    public function createDocument($name): Document
    {
        $document = Document::create([
            'name' => $name,
            'group_id' => optional($this->group)->id,
        ]);

        $this->emit('document:created', $document);

        return $document;
    }

    public function openDocument($uuid)
    {
        return redirect()->route('document:editor', $uuid);
    }

    public function deleteDocuments(array|Collection $documentsUuids): void
    {
        Document::whereIn('uuid', $documentsUuids)->delete();
    }

    public function createGroup($name): Group
    {
        $group = Group::create([
            'name' => $name,
            'parent_id' => optional($this->group)->id,
        ]);

        $this->emit('group:created', $group);

        return $group;
    }

    public function deleteGroups(array|Collection $groupUuids): void
    {
        collect($groupUuids)->each(function ($groupUuid) {
            optional(Group::whereUuid($groupUuid)->first())
                ->deleteDescendantDocuments()
                ->delete();
        });
    }

    public function deleteItems($groupUuids, $documentUuids): void
    {
        $this->deleteGroups($groupUuids);
        $this->deleteDocuments($documentUuids);
    }
}
