import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';
import React from 'react';
import { Bar } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
);

const BarChartComponent = ({ rawData, labels }) => {
  const options = {
    backgroundColor: '#EEEEEE',
    maintainAspectRatio: true,
    scales: {
      x: {
        beginAtZero: true,
        grid: {
          display: false,
        },
        type: 'category',
        ticks: {
          color: '#2B99FF',
          font: {
            weight: 700,
            size: '12px',
          },
        },
      },
      y: {
        beginAtZero: true,
        grid: {
          display: false,
        },
        ticks: {
          color: '#2B99FF',
          font: {
            weight: 700,
            size: '12px',
          },
        },
      },
    },
    layout: { autoPadding: true },
    title: {
      display: true,
      text: 'Average Rainfall per month',
      fontSize: 20,
    },
    plugins: {
      legend: {
        display: false,
      },
    },
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
      <Bar data={data} options={options} plugins={plugins} />
    </div>
  );
};

export default BarChartComponent;
