(function(d3) {
    'use strict';

    const color = (selection, props) => {
        const {
            cScale,
            circleRadius,
            spacing,
            textOffset
        } = props;
        const set = selection.selectAll('g')
            .data(cScale.domain());
        const colorset = set
            .enter().append('g')
            .attr('class', 'tick');
        colorset
            .merge(set)
            .attr('transform', (d, i) =>
                `translate(0, ${i * spacing})`
            );
        set.exit().remove();

        colorset.append('circle')
            .merge(set.select('circle'))
            .attr('r', circleRadius)
            .attr('fill', cScale);

        colorset.append('text')
            .merge(set.select('text'))
            .text(d => d)
            .attr('dy', '0.32em')
            .attr('x', textOffset);
    };
    const svg = d3.select('svg');

    const cScale = d3.scaleOrdinal()
        .domain(['<3000', '<6000', '<9000'])
        .range(['#deebf7', '#9ecae1', '#3182bd']);

    svg.append('g')
        .attr('transform', `translate(10,250)`)
        .call(color, {
            cScale,
            circleRadius: 8,
            spacing: 25,
            textOffset: 10
        });
}(d3));