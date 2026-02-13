{{-- resources/views/components/course-builder-sidebar.blade.php --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed; height: 100vh; overflow-y: auto;">
    <!-- Brand Logo -->
    <a href="{{ route('course.index') }}" class="brand-link">
        <i class="fas fa-graduation-cap brand-image ml-3" style="font-size: 1.2rem; line-height: 1.5;"></i>
        <span class="brand-text font-weight-light">Course Builder</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                
                {{-- Basic Info --}}
                <li class="nav-item">
                    <a href="{{ route('courses.basic', $course->id) }}"
                       class="nav-link {{ request()->routeIs('courses.basic') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            Basic Info
                            @if($course->title)
                                <i class="fas fa-check-circle text-success right"></i>
                            @else
                                <span class="right badge badge-secondary">○</span>
                            @endif
                        </p>
                    </a>
                </li>

                {{-- Curriculum --}}
                <li class="nav-item">
                    <a href="{{ route('courses.curriculum', $course->id) }}"
                       class="nav-link {{ request()->routeIs('courses.curriculum') ? 'active' : '' }} {{ !$course->title ? 'disabled' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Curriculum
                            <span class="right badge {{ $course->sections()->count() ? 'badge-success' : 'badge-secondary' }}">
                                {{ $course->sections()->count() ?: '○' }}
                            </span>
                        </p>
                    </a>
                </li>

                {{-- Requirements --}}
                <li class="nav-item">
                    <a href="{{ route('courses.materials', $course->id) }}"
                       class="nav-link {{ request()->routeIs('courses.materials') ? 'active' : '' }} {{ !$course->sections()->count() ? 'disabled' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Lecture Materials
                        @if($course->sections?->first()?->lectures?->first()?->materials?->count() ?? 0)
                            <i class="fas fa-check-circle text-success right"></i>
                        @else
                            <span class="right badge badge-secondary">○</span>
                        @endif
                        </p>
                    </a>
                </li>

                {{-- FAQs --}}
                <li class="nav-item">
                    <a href="{{ route('faq.index', $course->id) }}"
                       class="nav-link {{ request()->routeIs('faq.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            FAQs
                            <span class="right badge {{ $course->faqs()->count() ? 'badge-success' : 'badge-secondary' }}">
                                {{ $course->faqs()->count() ?: '○' }}
                            </span>
                        </p>
                    </a>
                </li>

                {{-- Pricing --}}
                <li class="nav-item">
                    <a href="{{ route('pricing.index', $course->id) }}"
                       class="nav-link {{ request()->routeIs('pricing.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Pricing
                            <span class="right badge {{ $course->pricing()->count() ? 'badge-success' : 'badge-secondary' }}">
                                {{ $course->pricing()->count() ?: '○' }}
                            </span>
                        </p>
                    </a>
                </li>

                {{-- Publish --}}
                <li class="nav-item">
                    <a href="{{ route('courses.publish', $course->id) }}"
                       class="nav-link {{ request()->routeIs('courses.publish') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rocket"></i>
                        <p>
                            Publish
                            {{-- <span class="right badge {{ $course->status === 'published' ? 'badge-success' : ($progress === 100 ? 'badge-warning' : 'badge-secondary') }}">
                                {{ ucfirst($course->status) }}
                            </span> --}}
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>