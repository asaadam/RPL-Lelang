
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Example');

import React, { PureComponent, createContext } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import { Layout, Menu, AutoComplete, Input, Button, Icon } from 'antd';

// Import component
import Header from './components/Header';
import Example from './components/Example';
import 'antd/dist/antd.css';  // or 'antd/dist/antd.less'
import './app.css';
import ButtonGroup from 'antd/lib/button/button-group';

export const AppContext = createContext();

const Option = AutoComplete.Option;
const OptGroup = AutoComplete.OptGroup;

const dataSource = [{
	title: '话题',
	children: [{
		title: 'AntDesign',
		count: 10000,
	}, {
		title: 'AntDesign UI',
		count: 10600,
	}],
}, {
	title: '问题',
	children: [{
		title: 'AntDesign UI 有多好',
		count: 60100,
	}, {
		title: 'AntDesign 是啥',
		count: 30010,
	}],
}, {
	title: '文章',
	children: [{
		title: 'AntDesign 是一个设计语言',
		count: 100000,
	}],
}];

function renderTitle(title) {
	return (
		<span>
			{title}
			<a
				style={{ float: 'right' }}
				href="https://www.google.com/search?q=antd"
				target="_blank"
				rel="noopener noreferrer"
			>更多
		</a>
		</span>
	);
}

const options = dataSource.map(group => (
	<OptGroup
		key={group.title}
		label={renderTitle(group.title)}
	>
		{group.children.map(opt => (
			<Option key={opt.title} value={opt.title}>
				{opt.title}
				<span className="certain-search-item-count">{opt.count} 人 关注</span>
			</Option>
		))}
	</OptGroup>
)).concat([
	<Option disabled key="all" className="show-all">
		<a
			href="https://www.google.com/search?q=antd"
			target="_blank"
			rel="noopener noreferrer"
		>
			查看所有结果
	  </a>
	</Option>,
]);

class App extends PureComponent {

	state = {
		success: true,
		trigger: () => {
			this.setState({ success: !this.state.success });
		}
	};

	render() {
		return (
			<AppContext.Provider value={this.state}>
				{/* <AppContext.Consumer>
					{(context) => console.log(context)}
				</AppContext.Consumer> */}
				<BrowserRouter>
					<Layout>
						<Layout.Header style={{ backgroundColor: 'white' }} className="header">
							<div className="logo" />
							<Menu
								theme={'light'}
								mode={'horizontal'}
								style={{ lineHeight: '64px' }}
							>
								<Menu.Item key="kategori">
									Kategori
								</Menu.Item>
								<Menu.Item>
									<div className="certain-category-search-wrapper" style={{ width: 250 }}>
										<AutoComplete
											className="certain-category-search"
											dropdownClassName="certain-category-search-dropdown"
											dropdownMatchSelectWidth={false}
											dropdownStyle={{ width: 300 }}
											size="large"
											style={{ width: '100%' }}
											dataSource={options}
											placeholder="input here"
											optionLabelProp="value"
										>
											<Input suffix={<Icon type="search" className="certain-category-icon" />} />
										</AutoComplete>
									</div>
								</Menu.Item>
								<ButtonGroup>
									<Button>
										MASUK
									</Button>
									<Button type="primary">
										DAFTAR
									</Button>
								</ButtonGroup>
							</Menu>
						</Layout.Header>
						<Layout.Content style={{ padding: '0 50px', marginTop: 64 }}>
							<Switch>
								<Route exact path='/' component={Example} />
								<Route path='/create' component={Example} />
							</Switch>
						</Layout.Content>
						<Layout.Footer style={{ textAlign: 'center' }}>
							{'Developed with <3 by us'}
						</Layout.Footer>
					</Layout>
				</BrowserRouter>
			</AppContext.Provider>
		);
	}
}

ReactDOM.render(<App />, document.getElementById('app'));