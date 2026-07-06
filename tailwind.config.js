/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    corePlugins: {
        preflight: false, // PENTING — biarkan Bootstrap reboot.css yang aktif (§3.1 DESIGN.md)
    },
    theme: {
        extend: {
            colors: {
                primary: {
                    50:  '#F2F8F5',
                    100: '#E6F1EC',
                    300: '#7FC2A8',
                    500: '#2D8A6B',
                    700: '#14543F',
                    900: '#0E3B2E',
                    950: '#082B22',
                },
                mint: {
                    100: '#DCEFE7',
                    500: '#5EBFA0',
                },
                teal: {
                    700: '#115E59',
                },
            },
            fontFamily: {
                sans: ['Inter', 'Segoe UI', 'Roboto', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'Consolas', 'Courier New', 'monospace'],
            },
            borderRadius: {
                md:  '0.375rem', // 6px — input, dropdown, tombol biasa
                lg:  '0.5rem',   // 8px — kartu standar
                xl:  '0.75rem',  // 12px — kartu KPI, modal
            },
            boxShadow: {
                'elev-1': '0 1px 2px rgba(15, 30, 44, 0.04), 0 1px 3px rgba(15, 30, 44, 0.03)',
                'elev-2': '0 4px 12px rgba(15, 30, 44, 0.06), 0 2px 4px rgba(15, 30, 44, 0.04)',
                'elev-3': '0 10px 24px rgba(15, 30, 44, 0.08)',
            },
        },
    },
    plugins: [],
};
