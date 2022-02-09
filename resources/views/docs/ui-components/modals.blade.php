@extends('gc::layouts.docs')

@section('title', 'Modals')

@section('content')

    <x-gc::component-preview name="modal" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::button x-data="{}" @click="$store.modals.example = true">Open Modal</x-gc::button>

<x-gc::modal id="example">
    <x-slot name="title">Example Modal</x-slot>
    <x-slot name="icon">
        <x-heroicon-o-cube/>
    </x-slot>
    This is the modal
</x-gc::modal>')
            @endphp
        </x-slot>
        <x-gc::button x-data="{}" @click="$store.modals.example = true">Open Modal</x-gc::button>
        <x-gc::modal id="example">
            <x-slot name="title">Example Modal</x-slot>
            <x-slot name="icon">
                <x-heroicon-o-cube/>
            </x-slot>
            This is the modal
        </x-gc::modal>

        <x-slot name="dark">
            <x-gc::button x-data="{}" @click="$store.modals.darkExample = true">Open Modal</x-gc::button>

            <x-gc::modal id="darkExample">
                <x-slot name="title">The Dark Modal</x-slot>
                <x-slot name="icon">
                    <x-heroicon-o-adjustments/>
                </x-slot>
                This is the dark modal
            </x-gc::modal>
        </x-slot>

    </x-gc::component-preview>

    <x-gc::component-preview name="modal" label="Slide over modal" no-disabled>
        <x-slot name="code">
            @php
                echo e('<x-gc::button x-data="{}" @click="$store.modals.slideover = true">Open Slide Over</x-gc::button>

<x-gc::modal slide-over id="slideover" />')
            @endphp
        </x-slot>
        <x-gc::button x-data="{}" @click="$store.modals.slideover = true">Open Slide Over</x-gc::button>
        <x-gc::modal slide-over id="slideover">
            <x-slot name="title">Example Slide Over Modal</x-slot>
            <x-slot name="icon">
                <x-heroicon-o-cube/>
            </x-slot>
            This is the slide over modal
        </x-gc::modal>

        <x-slot name="dark">
            <x-gc::button x-data="{}" @click="$store.modals.darkSlideOver = true">Open Slide Over</x-gc::button>

            <x-gc::modal slide-over id="darkSlideOver">
                <x-slot name="title">The Dark Slide Over</x-slot>
                <x-slot name="icon">
                    <x-heroicon-o-document-search/>
                </x-slot>
                <div class="prose prose-dark">
                    <h2>This is the dark slide over modal</h2>
                    <p>
                        Cupidatat ullamco sint eu proident quis officia labore eiusmod duis. Officia eu do proident
                        pariatur. Adipisicing excepteur velit eu aute proident excepteur elit sunt incididunt occaecat
                        ex. Elit excepteur ex eiusmod voluptate culpa mollit et commodo ipsum. Laboris dolor excepteur
                        non id amet laboris voluptate dolor do est aute. Duis aliquip nulla elit culpa enim. Minim
                        aliquip non ex culpa commodo eu dolor duis mollit amet occaecat voluptate nostrud. Qui esse enim
                        sint occaecat aliqua commodo consectetur voluptate irure eiusmod ullamco. Veniam officia et
                        fugiat consectetur enim occaecat cupidatat adipisicing anim nostrud. Do aliqua dolor fugiat amet
                        fugiat laborum qui ullamco amet ea dolore consectetur. </p>
                    <p>
                        Culpa eiusmod aute ipsum aliqua laborum adipisicing voluptate non sit et nisi duis cillum
                        laboris. Cupidatat aliqua laboris dolore magna reprehenderit minim sunt aliqua est anim irure
                        eiusmod. Excepteur reprehenderit reprehenderit consequat nisi amet ad deserunt cupidatat anim
                        consequat dolor est mollit exercitation. Sit commodo incididunt proident non aute amet elit in
                        culpa. Elit reprehenderit est cupidatat id esse cillum exercitation irure labore non proident
                        duis tempor veniam. Enim consectetur labore laboris elit magna eiusmod incididunt. Non quis
                        velit fugiat quis Lorem amet magna elit tempor ullamco Lorem consequat. Amet reprehenderit
                        labore commodo enim pariatur voluptate labore esse laboris excepteur. Nisi exercitation dolor
                        fugiat culpa enim do sit quis mollit sunt amet fugiat ut pariatur. Excepteur labore incididunt
                        fugiat dolore eiusmod non quis esse. </p>
                    <p>
                        Minim ea voluptate nulla excepteur amet fugiat ea labore ut dolore magna anim irure. Sint et
                        aliquip deserunt Lorem sunt laborum est exercitation tempor cupidatat amet ex. Proident enim
                        exercitation nostrud cillum. Lorem aute ea culpa mollit aute cillum qui cillum amet tempor nisi.
                        Sint excepteur id duis. Non deserunt nostrud enim ex. Ipsum occaecat consequat commodo id dolore
                        ipsum pariatur mollit adipisicing consequat eiusmod eiusmod Lorem voluptate officia. Ad velit
                        fugiat ex aliquip sint elit sint. Magna id laborum enim ipsum nulla mollit ad adipisicing
                        nostrud consectetur culpa consequat cupidatat aliquip. Ad eu amet voluptate ullamco aliqua sint
                        do aute enim esse magna aliquip reprehenderit mollit. </p>
                    <p>
                        Ad officia quis officia veniam laboris laborum culpa. Non amet esse ipsum aute. Duis commodo
                        dolore aliqua ullamco eu dolore Lorem. Ullamco voluptate tempor deserunt pariatur nostrud.
                        Voluptate commodo quis aute incididunt fugiat sit consectetur laboris mollit eu aliqua amet
                        laborum esse. Id deserunt sit commodo fugiat magna veniam fugiat id esse. Eu do proident
                        voluptate laborum et nisi adipisicing ea. Deserunt enim ullamco esse. Elit officia eiusmod esse
                        aute. Deserunt proident incididunt duis ad esse reprehenderit aliquip labore anim laboris non
                        voluptate excepteur id veniam.
                    </p>
                    <p>
                        Laborum veniam consectetur nisi et dolor nostrud. Eu nostrud enim deserunt irure veniam velit eu
                        non esse dolor sit enim reprehenderit reprehenderit. Sunt non do excepteur. Consectetur
                        consequat labore consequat sint laborum cupidatat veniam sint magna in Lorem elit. Aliquip dolor
                        adipisicing consectetur nisi irure. Ad cillum commodo deserunt. Enim ad eiusmod enim nostrud non
                        anim. Ad proident quis velit Lorem dolor adipisicing nisi nostrud. Velit voluptate dolor in et
                        sunt ut ut laborum non do aliquip aliqua officia laborum enim. Qui sint adipisicing laboris non
                        mollit amet exercitation irure.
                    </p>
                </div>
            </x-gc::modal>
        </x-slot>

        <x-slot name="disabled"></x-slot>
    </x-gc::component-preview>

@endsection
