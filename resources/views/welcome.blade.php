
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Control Center</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: Inter, Arial, sans-serif;
            background: #0b1120; color: #e5e7eb;
        }
        .layout { display: flex; min-height: 100vh; }
        aside {
            width: 235px; padding: 28px 18px; background: #111827;
            border-right: 1px solid #263247; flex-shrink: 0;
        }
        .brand { font-size: 20px; font-weight: 800; margin-bottom: 38px; }
        .brand span { color: #60a5fa; }
        .nav { display: grid; gap: 8px; }
        .nav button {
            width: 100%; text-align: left; padding: 12px;
            color: #9ca3af; background: transparent; border: 0;
            border-radius: 9px; cursor: pointer; font-size: 14px;
        }
        .nav button:hover, .nav button.active {
            color: white; background: #243047;
        }
        main { flex: 1; min-width: 0; padding: 32px; }
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; flex-wrap: wrap; margin-bottom: 30px;
        }
        h1 { font-size: 28px; margin: 0 0 8px; }
        .muted { color: #9ca3af; font-size: 14px; }
        .button {
            background: #3b82f6; color: white; border: 0;
            border-radius: 9px; padding: 11px 15px; cursor: pointer;
            font-weight: 600;
        }
        .button:hover { background: #2563eb; }
        .button.secondary { background: #263247; }
        .cards {
            display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px; margin-bottom: 24px;
        }
        .card, .panel {
            background: #111b2e; border: 1px solid #263247;
            border-radius: 14px; padding: 21px;
        }
        .card-label { color: #9ca3af; font-size: 13px; }
        .number { font-size: 30px; font-weight: 750; margin: 12px 0 7px; }
        .green { color: #4ade80; }
        .blue { color: #60a5fa; }
        .purple { color: #c4b5fd; }
        .section-title {
            display: flex; justify-content: space-between; align-items: center;
            gap: 12px; flex-wrap: wrap; margin-bottom: 18px;
        }
        h2 { font-size: 18px; margin: 0; }
        .toolbar { display: flex; gap: 9px; flex-wrap: wrap; }
        input, select {
            background: #0b1120; border: 1px solid #354158;
            border-radius: 8px; padding: 10px 12px; color: white;
            font-size: 14px; min-width: 0;
        }
        #search { width: 210px; }
        .task {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 0; border-bottom: 1px solid #263247;
        }
        .task:last-child { border-bottom: 0; }
        .task input { accent-color: #3b82f6; }
        .task-name { flex: 1; overflow-wrap: anywhere; }
        .task.done .task-name {
            text-decoration: line-through; color: #6b7280;
        }
        .tag {
            font-size: 11px; color: #93c5fd; background: #172c49;
            padding: 5px 8px; border-radius: 20px;
        }
        .delete {
            border: 0; background: transparent; color: #f87171;
            cursor: pointer; font-size: 18px;
        }
        .empty { color: #9ca3af; padding: 25px 0; text-align: center; }
        .notice {
            margin-top: 18px; padding: 13px; border-radius: 9px;
            background: #142c26; color: #86efac; font-size: 13px;
        }
        footer { color: #6b7280; font-size: 12px; margin-top: 26px; }
        @media (max-width: 850px) {
            .cards { grid-template-columns: 1fr; }
            aside { width: 185px; }
            main { padding: 22px; }
        }
        @media (max-width: 600px) {
            .layout { display: block; }
            aside { width: 100%; padding: 16px; }
            .brand { margin-bottom: 14px; }
            .nav { grid-template-columns: repeat(3, 1fr); }
            .nav button { text-align: center; padding: 10px 5px; }
            main { padding: 18px; }
            h1 { font-size: 24px; }
            #search { width: 100%; }
            .toolbar { width: 100%; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside>
        <div class="brand">Laravel<span>.</span>Lab</div>
        <nav class="nav">
            <button class="active" data-page="overview">▦ &nbsp; Overview</button>
            <button data-page="tasks">✓ &nbsp; Task Manager</button>
            <button data-page="system">⚙ &nbsp; System Status</button>
        </nav>
        <div class="notice">● Demo dashboard is running</div>
    </aside>

    <main>
        <header class="topbar">
            <div>
                <h1 id="pageTitle">Overview</h1>
                <div class="muted">Your Laravel application control center</div>
            </div>
            <button class="button" id="addTop">+ Add Task</button>
        </header>

        <section class="cards">
            <div class="card">
                <div class="card-label">Total Tasks</div>
                <div class="number blue" id="total">3</div>
                <div class="muted">Tasks in your workspace</div>
            </div>
            <div class="card">
                <div class="card-label">Completed</div>
                <div class="number green" id="completed">1</div>
                <div class="muted">Tasks marked as done</div>
            </div>
            <div class="card">
                <div class="card-label">Remaining</div>
                <div class="number purple" id="remaining">2</div>
                <div class="muted">Tasks to work on</div>
            </div>
        </section>

        <section class="panel" id="taskPanel">
            <div class="section-title">
                <h2>My Tasks</h2>
                <div class="toolbar">
                    <input id="search" type="search" placeholder="Search tasks...">
                    <select id="filter" aria-label="Filter tasks">
                        <option value="all">All tasks</option>
                        <option value="active">Pending</option>
                        <option value="done">Completed</option>
                    </select>
                </div>
            </div>
            <div id="taskList"></div>
        </section>

        <section class="panel" id="systemPanel" hidden>
            <h2>Application Status</h2>
            <div class="task">
                <span class="green">●</span>
                <span class="task-name">Laravel web application</span>
                <span class="tag">Responding</span>
            </div>
            <div class="task">
                <span class="green">●</span>
                <span class="task-name">Docker deployment</span>
                <span class="tag">Configured</span>
            </div>
            <div class="task">
                <span class="green">●</span>
                <span class="task-name">Jenkins pipeline</span>
                <span class="tag">Build #1 passed</span>
            </div>
            <p class="muted">These are demo indicators, not live health checks.</p>
        </section>

        <footer>Laravel Lab · Interactive frontend demo</footer>
    </main>
</div>

<script>
    const initialTasks = [
        { id: 1, name: 'Check Laravel frontend', done: true },
        { id: 2, name: 'Verify Docker containers', done: false },
        { id: 3, name: 'Review Jenkins deployment', done: false }
    ];

    let tasks;
    try {
        tasks = JSON.parse(localStorage.getItem('laravel-demo-tasks')) || initialTasks;
    } catch {
        tasks = initialTasks;
    }

    const list = document.getElementById('taskList');
    const search = document.getElementById('search');
    const filter = document.getElementById('filter');

    function save() {
        localStorage.setItem('laravel-demo-tasks', JSON.stringify(tasks));
    }

    function render() {
        const query = search.value.toLowerCase().trim();
        const mode = filter.value;
        const visible = tasks.filter(task => {
            const matchesText = task.name.toLowerCase().includes(query);
            const matchesMode = mode === 'all' ||
                (mode === 'done' && task.done) ||
                (mode === 'active' && !task.done);
            return matchesText && matchesMode;
        });

        document.getElementById('total').textContent = tasks.length;
        document.getElementById('completed').textContent =
            tasks.filter(task => task.done).length;
        document.getElementById('remaining').textContent =
            tasks.filter(task => !task.done).length;

        list.replaceChildren();

        if (!visible.length) {
            const empty = document.createElement('div');
            empty.className = 'empty';
            empty.textContent = 'No matching tasks. Add a task to get started!';
            list.appendChild(empty);
            return;
        }

        visible.forEach(task => {
            const row = document.createElement('div');
            row.className = 'task' + (task.done ? ' done' : '');

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = task.done;
            checkbox.setAttribute('aria-label', 'Mark task complete');
            checkbox.addEventListener('change', () => {
                task.done = checkbox.checked;
                save();
                render();
            });

            const name = document.createElement('span');
            name.className = 'task-name';
            name.textContent = task.name;

            const tag = document.createElement('span');
            tag.className = 'tag';
            tag.textContent = task.done ? 'Completed' : 'Pending';

            const remove = document.createElement('button');
            remove.className = 'delete';
            remove.textContent = '×';
            remove.title = 'Delete task';
            remove.setAttribute('aria-label', 'Delete ' + task.name);
            remove.addEventListener('click', () => {
                tasks = tasks.filter(item => item.id !== task.id);
                save();
                render();
            });

            row.append(checkbox, name, tag, remove);
            list.appendChild(row);
        });
    }

    function addTask() {
        const name = prompt('Enter a task name:');
        if (!name || !name.trim()) return;

        tasks.unshift({
            id: Date.now(),
            name: name.trim(),
            done: false
        });
        save();
        search.value = '';
        filter.value = 'all';
        render();
    }

    document.getElementById('addTop').addEventListener('click', addTask);
    search.addEventListener('input', render);
    filter.addEventListener('change', render);

    document.querySelectorAll('[data-page]').forEach(button => {
        button.addEventListener('click', () => {
            const page = button.dataset.page;
            document.querySelectorAll('[data-page]').forEach(item =>
                item.classList.toggle('active', item === button)
            );

            document.getElementById('pageTitle').textContent =
                page === 'overview' ? 'Overview' :
                page === 'tasks' ? 'Task Manager' : 'System Status';

            document.getElementById('taskPanel').hidden = page === 'system';
            document.querySelector('.cards').hidden = page !== 'overview';
            document.getElementById('systemPanel').hidden = page !== 'system';
            document.getElementById('addTop').hidden = page === 'system';

            if (page === 'tasks') {
                document.getElementById('taskPanel').scrollIntoView({
                    behavior: 'smooth', block: 'start'
                });
            }
        });
    });

    render();
</script>
</body>
</html>
