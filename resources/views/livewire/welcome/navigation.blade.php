<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-md px-3 py-2 text-lg font-bold"
        >
            Dashboard
        </a>
    @else
    @endauth
</nav>
