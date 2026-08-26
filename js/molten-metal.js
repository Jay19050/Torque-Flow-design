/*
 * Vanilla WebGL2 adaptation of the Molten Metal effect by React Bits.
 * It is intentionally mounted only on the post-hero sections of index.php.
 */
(() => {
    'use strict';

    const vertexSource = `#version 300 es
        in vec2 position;
        void main() { gl_Position = vec4(position, 0.0, 1.0); }
    `;

    const fragmentSource = `#version 300 es
        precision highp float;
        uniform vec2 iResolution;
        uniform float iTime;
        uniform vec2 uMouse;
        out vec4 fragColor;

        float hash(vec2 p) {
            return fract(sin(dot(p, vec2(12.9898, 78.233))) * 43758.5453);
        }

        void main() {
            float time = iTime * 0.3;
            vec2 p = 4.0 * ((gl_FragCoord.xy - 0.5 * iResolution.xy) / iResolution.y) - 0.5;
            p += (uMouse - 0.5) * 0.32;

            vec2 i = p;
            float c = 0.0;
            float r = length(p + vec2(sin(time), sin(time * 0.3 + 5.0)) * 0.5);
            float d = length(p);
            float rot = d + time + p.x;
            float cosRot = cos(rot);
            mat2 warp = mat2(cos(rot - sin(time / 5.0)), sin(rot), -sin(cosRot - time), cosRot) * -0.2;

            for (float n = 0.0; n < 3.0; n++) {
                p *= warp;
                float t = r - time / (n + 3.0);
                i -= p + vec2(cos(t - i.x - r) + sin(t + i.y), sin(t - i.y) + cos(t + i.x) + r);
                c += 0.125 / length(vec2(sin(i.x + t), cos(i.y + t)));
            }

            float intensity = max(c / 6.0 - 0.05, 0.0) * 1.3;
            float glow = clamp(intensity * 1.25, 0.0, 1.0);
            vec3 shadow = vec3(0.09, 0.012, 0.002);
            vec3 midtone = vec3(0.72, 0.105, 0.006);
            vec3 highlight = vec3(1.0, 0.54, 0.16);
            vec3 color = mix(shadow, midtone, smoothstep(0.0, 0.5, glow));
            color = mix(color, highlight, smoothstep(0.5, 1.0, glow));

            float alpha = clamp(glow + (hash(gl_FragCoord.xy + iTime) - 0.5) * 0.035, 0.0, 1.0) * 0.72;
            fragColor = vec4(color * alpha, alpha);
        }
    `;

    const createShader = (gl, type, source) => {
        const shader = gl.createShader(type);
        gl.shaderSource(shader, source);
        gl.compileShader(shader);
        if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
            gl.deleteShader(shader);
            return null;
        }
        return shader;
    };

    const mountMoltenMetal = (section) => {
        const canvas = document.createElement('canvas');
        canvas.className = 'tf-molten-metal';
        canvas.setAttribute('aria-hidden', 'true');
        section.prepend(canvas);

        const gl = canvas.getContext('webgl2', { alpha: true, antialias: false, premultipliedAlpha: true });
        if (!gl) {
            canvas.remove();
            return;
        }

        const vertex = createShader(gl, gl.VERTEX_SHADER, vertexSource);
        const fragment = createShader(gl, gl.FRAGMENT_SHADER, fragmentSource);
        if (!vertex || !fragment) {
            canvas.remove();
            return;
        }

        const program = gl.createProgram();
        gl.attachShader(program, vertex);
        gl.attachShader(program, fragment);
        gl.linkProgram(program);
        gl.deleteShader(vertex);
        gl.deleteShader(fragment);
        if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
            canvas.remove();
            return;
        }

        const buffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);
        const position = gl.getAttribLocation(program, 'position');
        const resolution = gl.getUniformLocation(program, 'iResolution');
        const time = gl.getUniformLocation(program, 'iTime');
        const mouse = gl.getUniformLocation(program, 'uMouse');
        const targetMouse = [0.5, 0.5];
        const currentMouse = [0.5, 0.5];
        let frame = 0;
        let visible = false;
        let pageVisible = !document.hidden;

        const resize = () => {
            const rect = section.getBoundingClientRect();
            const scale = Math.min(window.devicePixelRatio || 1, 1.5);
            canvas.width = Math.max(1, Math.floor(rect.width * scale));
            canvas.height = Math.max(1, Math.floor(rect.height * scale));
            gl.viewport(0, 0, canvas.width, canvas.height);
        };

        const render = (now) => {
            currentMouse[0] += (targetMouse[0] - currentMouse[0]) * 0.045;
            currentMouse[1] += (targetMouse[1] - currentMouse[1]) * 0.045;
            gl.useProgram(program);
            gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
            gl.enableVertexAttribArray(position);
            gl.vertexAttribPointer(position, 2, gl.FLOAT, false, 0, 0);
            gl.uniform2f(resolution, canvas.width, canvas.height);
            gl.uniform1f(time, now * 0.001);
            gl.uniform2f(mouse, currentMouse[0], currentMouse[1]);
            gl.drawArrays(gl.TRIANGLES, 0, 3);
            frame = requestAnimationFrame(render);
        };

        const start = () => {
            if (visible && pageVisible && !frame) frame = requestAnimationFrame(render);
        };
        const stop = () => {
            if (frame) cancelAnimationFrame(frame);
            frame = 0;
        };

        const observer = new IntersectionObserver(([entry]) => {
            visible = entry.isIntersecting;
            visible ? start() : stop();
        }, { threshold: 0 });
        const resizeObserver = new ResizeObserver(resize);
        const onPointerMove = (event) => {
            const rect = section.getBoundingClientRect();
            targetMouse[0] = (event.clientX - rect.left) / rect.width;
            targetMouse[1] = 1 - (event.clientY - rect.top) / rect.height;
        };
        const onPointerLeave = () => {
            targetMouse[0] = 0.5;
            targetMouse[1] = 0.5;
        };
        const onVisibilityChange = () => {
            pageVisible = !document.hidden;
            pageVisible ? start() : stop();
        };

        resize();
        observer.observe(section);
        resizeObserver.observe(section);
        section.addEventListener('pointermove', onPointerMove, { passive: true });
        section.addEventListener('pointerleave', onPointerLeave, { passive: true });
        document.addEventListener('visibilitychange', onVisibilityChange);
    };

    const init = () => {
        const page = document.querySelector('.home-page, .services-page');
        if (!page || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const sections = document.body.classList.contains('page-home')
            ? '.home-page > section:not(.tf-hero)'
            : '.services-page > section:not(.services-hero)';
        document.querySelectorAll(sections).forEach(mountMoltenMetal);
    };

    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', init, { once: true }) : init();
})();
