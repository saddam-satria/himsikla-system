import {
    Chart as ChartJS,
    Tooltip,
    Legend,
    ArcElement,
  } from 'chart.js';
  import React from 'react';
  import { Pie } from 'react-chartjs-2';
  
  ChartJS.register(ArcElement, Tooltip, Legend);
  
  const PiechartComponent = ({ rawData, labels }) => {
    
    const options = {
      responsive: true,
      maintainAspectRatio: true,
    };
    const plugins = [
      {
        beforeDraw: (chart) => {
          const ctx = chart.canvas.getContext('2d');
          ctx.save();
          const { height, width, left, top } = chart.chartArea;
          ctx.globalCompositeOperation = 'destination-over';
          ctx.fillStyle = '#EEEEEE';
          ctx.fillRect(left, top, width, height);
          ctx.restore();
        },
      },
    ];
  
    const data = {
      labels,
      datasets: [
        {
          label: 'Jumlah Suara Kandidat',
          data: rawData,
          backgroundColor: [
            'rgb(0, 147, 255)',
            'rgb(0, 147, 200)',
            'rgba(0, 147, 150, 0.2)',
            'rgba(0, 147, 190)',
          ],
        },
      ],
    };
  
    return (
      <div>
        <Pie data={data} options={options} plugins={plugins} />
      </div>
    );
  };
  
  export default PiechartComponent;
  