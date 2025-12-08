@props([
    'modalId',
    'title',
    'body',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmAction' => '#',
    'confirmMethod' => 'POST',
    'iconClass' => 'bi-exclamation-triangle-fill text-warning', // Default icon
    'confirmButtonClass' => 'btn-primary', // Default button color
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--medium-blue); border: 1px solid var(--light-blue);">
            <div class="modal-header border-0 text-center pb-0 d-block">
                <i class="bi {{ $iconClass }}" style="font-size: 3rem; color: var(--primary-color-light);"></i>
                <h4 class="modal-title mt-3" id="{{ $modalId }}Label">{{ $title }}</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 1rem; right: 1rem;"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p style="color: var(--text-secondary);">{{ $body }}</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <form id="confirmForm-{{ $modalId }}" action="{{ $confirmAction }}" method="POST" class="d-inline">
                    @csrf
                    @if(strtoupper($confirmMethod) !== 'POST')
                        @method($confirmMethod)
                    @endif
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        {{ $cancelText }}
                    </button>
                    <button type="submit" class="btn {{ $confirmButtonClass }} px-4">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>